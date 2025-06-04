#!/bin/bash

# Laravel Production Deployment Script for Coolify
echo "🚀 Starting Laravel deployment..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

echo "📦 Installing Node.js dependencies with Yarn..."
yarn install --frozen-lockfile

# Build assets
echo "🏗️ Building frontend assets..."
yarn build

# Laravel optimizations
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache public/build

echo "✅ Deployment completed successfully!"
echo "🌐 Your application should now be accessible with proper CSS and assets." 