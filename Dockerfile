# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libssl-dev \
    default-mysql-client \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Install Yarn globally
RUN npm install -g yarn

# Set working directory
WORKDIR /var/www/html

# Configure Apache document root to point to public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy all application files
COPY . .

# Remove any npm lock files to avoid conflicts with yarn
RUN rm -f package-lock.json

# Install Node.js dependencies with yarn
RUN yarn install --production=false

# Install PHP dependencies without running scripts initially
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Now run the composer scripts manually to avoid artisan issues
RUN composer dump-autoload --optimize

# Build frontend assets for production (using a temporary .env for build)
RUN echo "APP_NAME=Laravel\n\
APP_ENV=production\n\
APP_KEY=base64:$(openssl rand -base64 32)\n\
APP_DEBUG=false\n\
APP_URL=http://localhost\n\
LOG_CHANNEL=stack\n\
LOG_DEPRECATIONS_CHANNEL=null\n\
LOG_LEVEL=error\n\
DB_CONNECTION=mysql\n\
DB_HOST=localhost\n\
DB_PORT=3306\n\
DB_DATABASE=laravel\n\
DB_USERNAME=root\n\
DB_PASSWORD=\n\
SESSION_DRIVER=file\n\
BROADCAST_DRIVER=log\n\
CACHE_DRIVER=file\n\
FILESYSTEM_DISK=local\n\
QUEUE_CONNECTION=sync\n\
SESSION_LIFETIME=120\n\
VITE_APP_NAME=Laravel" > .env.build \
    && cp .env.build .env \
    && yarn build \
    && rm .env.build .env

# Fix Vite manifest path - Laravel expects it at public/build/manifest.json
RUN if [ -f "/var/www/html/public/build/.vite/manifest.json" ]; then \
        cp /var/www/html/public/build/.vite/manifest.json /var/www/html/public/build/manifest.json; \
    fi

# Debug: List all generated assets
RUN echo "📦 Generated assets:" && \
    find /var/www/html/public/build -type f -name "*.css" -o -name "*.js" | head -10 && \
    echo "📋 Manifest content:" && \
    head -10 /var/www/html/public/build/manifest.json 2>/dev/null || echo "No manifest found"

# Ensure build directory exists and has proper permissions
RUN mkdir -p /var/www/html/public/build \
    && chmod -R 755 /var/www/html/public/build

# Set permissions for Laravel directories
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Configure PHP with higher memory limits and longer execution time
RUN echo "memory_limit=256M\n\
upload_max_filesize=64M\n\
post_max_size=64M\n\
max_execution_time=300" > /usr/local/etc/php/conf.d/custom.ini

# Configure PHP for production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Create Apache virtual host configuration for better asset serving
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    \n\
    # Handle Vite assets with proper headers\n\
    <LocationMatch "\\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$">\n\
        ExpiresActive On\n\
        ExpiresDefault "access plus 1 year"\n\
        Header append Cache-Control "public, immutable"\n\
    </LocationMatch>\n\
    \n\
    # Handle build directory specifically\n\
    <Directory /var/www/html/public/build>\n\
        AllowOverride None\n\
        Require all granted\n\
        Header set Cache-Control "public, max-age=31536000, immutable"\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80

# Startup script
RUN echo '#!/bin/bash\n\
echo "🚀 Starting Laravel application..."\n\
\n\
# Create .env file with runtime environment variables\n\
cat > .env << EOF\n\
APP_NAME="${APP_NAME:-Laravel_Order_Processing}"\n\
APP_ENV=${APP_ENV:-production}\n\
APP_KEY=${APP_KEY:-}\n\
APP_DEBUG=${APP_DEBUG:-false}\n\
APP_URL=${APP_URL:-http://localhost}\n\
LOG_CHANNEL=stack\n\
LOG_DEPRECATIONS_CHANNEL=null\n\
LOG_LEVEL=error\n\
DB_CONNECTION=mysql\n\
DB_HOST=${DB_HOST:-localhost}\n\
DB_PORT=${DB_PORT:-3306}\n\
DB_DATABASE=${DB_DATABASE:-laravel}\n\
DB_USERNAME=${DB_USERNAME:-root}\n\
DB_PASSWORD=${DB_PASSWORD:-}\n\
SESSION_DRIVER=file\n\
BROADCAST_DRIVER=log\n\
CACHE_DRIVER=file\n\
FILESYSTEM_DISK=local\n\
QUEUE_CONNECTION=sync\n\
SESSION_LIFETIME=120\n\
VITE_APP_NAME=Laravel\n\
EOF\n\
\n\
# Generate application key if not set\n\
if [ -z "$APP_KEY" ] || grep -q "APP_KEY=$" .env; then\n\
    echo "Generating new APP_KEY..."\n\
    php artisan key:generate --force\n\
else\n\
    echo "Using existing APP_KEY from environment"\n\
fi\n\
\n\
# Check if manifest exists and rebuild if needed\n\
if [ ! -f "/var/www/html/public/build/manifest.json" ]; then\n\
    echo "⚠️  Vite manifest not found, rebuilding assets..."\n\
    yarn build || echo "❌ Asset build failed, but continuing..."\n\
    \n\
    # Fix manifest path after rebuild\n\
    if [ -f "/var/www/html/public/build/.vite/manifest.json" ]; then\n\
        echo "📋 Copying manifest from .vite subdirectory to expected location"\n\
        cp /var/www/html/public/build/.vite/manifest.json /var/www/html/public/build/manifest.json\n\
    fi\n\
fi\n\
\n\
# Ensure proper permissions for build directory\n\
chown -R www-data:www-data /var/www/html/public/build\n\
chmod -R 755 /var/www/html/public/build\n\
\n\
# Debug: Check if manifest exists and show CSS files\n\
if [ -f "/var/www/html/public/build/manifest.json" ]; then\n\
    echo "✅ Manifest found at: /var/www/html/public/build/manifest.json"\n\
    echo "📄 Manifest size: $(stat -c%s /var/www/html/public/build/manifest.json) bytes"\n\
    echo "🔍 First few lines of manifest:"\n\
    head -5 /var/www/html/public/build/manifest.json\n\
    echo ""\n\
    echo "🎨 CSS files in build directory:"\n\
    find /var/www/html/public/build -name "*.css" | head -5 || echo "No CSS files found"\n\
    echo ""\n\
    echo "📦 All files in build directory:"\n\
    ls -la /var/www/html/public/build/ | head -10\n\
else\n\
    echo "❌ Manifest still missing after rebuild attempt"\n\
    echo "📁 Contents of public/build directory:"\n\
    ls -la /var/www/html/public/build/ || echo "Directory does not exist"\n\
    echo "📁 Contents of public/build/.vite directory:"\n\
    ls -la /var/www/html/public/build/.vite/ || echo ".vite directory does not exist"\n\
fi\n\
\n\
# Wait for dependencies\n\
sleep 5\n\
\n\
# Run database migrations with force flag\n\
echo "🗄️  Running database migrations..."\n\
php artisan migrate --force || echo "⚠️  Migration failed, but continuing..."\n\
\n\
# Clear all caches before optimization\n\
php artisan config:clear\n\
php artisan route:clear\n\
php artisan view:clear\n\
\n\
# Optimize for production\n\
php artisan config:cache\n\
# Skip route cache for now due to route conflicts\n\
# php artisan route:cache\n\
php artisan view:cache\n\
\n\
echo "✅ Laravel optimized for production"\n\
echo "🌐 Starting Apache server..."\n\
\n\
# Start Apache\n\
apache2-foreground' > /usr/local/bin/startup.sh && \
chmod +x /usr/local/bin/startup.sh

# Start Apache with our startup script
CMD ["/usr/local/bin/startup.sh"]
