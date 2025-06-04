# Coolify Configuration Fixes for Laravel Application

## Current Issues and Solutions

### 1. Port Configuration
**Problem**: You have conflicting port settings
- Ports Exposed: 80 ✅ (correct)
- Ports Mappings: 3000:3000 ❌ (wrong)

**Fix**: 
- Keep "Ports Exposed" as: `80`
- **Remove** the "Ports Mappings" entry (leave it empty)
- Coolify will automatically map the exposed port

### 2. Pre-deployment Commands
**Problem**: `php artisan migrate` runs before container is ready

**Fix**: Move this to Post-deployment instead:
- Pre-deployment: (leave empty)
- Post-deployment: `php artisan migrate --force`

### 3. Custom Docker Options
**Problem**: These options might interfere with Laravel deployment:
```
--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k --hostname=myapp
```

**Fix**: Remove all custom Docker options (leave empty) unless specifically needed

### 4. Base Directory
**Current**: `/`
**Recommended**: Leave empty or use `.`

### 5. Watch Paths
**Current**: `src/pages/**`
**Fix**: For Laravel, use: `app/** resources/** routes/** config/** database/**`

## Correct Coolify Configuration

### General Tab:
- **Name**: Oder-Processing ✅
- **Build Pack**: Dockerfile ✅
- **Domains**: https://orderprocessing.divinecareindustries.com ✅

### Build Tab:
- **Base Directory**: (empty)
- **Dockerfile Location**: `/Dockerfile` ✅
- **Docker Build Stage Target**: (empty)
- **Watch Paths**: `app/** resources/** routes/** config/** database/**`
- **Custom Docker Options**: (empty)

### Network Tab:
- **Ports Exposed**: `80`
- **Ports Mappings**: (empty)

### Pre/Post Deployment Commands:
- **Pre-deployment**: (empty)
- **Post-deployment**: 
```bash
php artisan config:clear && php artisan config:cache && php artisan route:clear && php artisan route:cache && php artisan view:clear && php artisan view:cache && php artisan migrate --force
```

## Environment Variables to Set

In Coolify's Environment Variables section, make sure you have:

```bash
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-generated-key-here
APP_URL=https://orderprocessing.divinecareindustries.com

# Database settings (configure based on your database service)
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# Cache and Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Vite (important for assets)
VITE_APP_NAME="${APP_NAME}"
```

## Steps to Fix:

1. **Update Port Configuration**:
   - Remove the "3000:3000" from Port Mappings
   - Keep only "80" in Ports Exposed

2. **Clear Custom Docker Options**:
   - Remove all the custom Docker options

3. **Update Deployment Commands**:
   - Clear Pre-deployment commands
   - Set Post-deployment to the Laravel optimization commands

4. **Force Clean Build**:
   - Go to your application in Coolify
   - Click "Deploy" 
   - Enable "Force rebuild" option
   - Deploy

5. **Check Build Logs**:
   - Monitor the build process to ensure it uses yarn instead of npm
   - Verify that assets are being built properly

## Additional Troubleshooting

If you still get the "Could not open input file: artisan" error:

1. **Check Repository Sync**: Ensure your latest Dockerfile is pushed to your Git repository
2. **Clear Build Cache**: In Coolify, try clearing the build cache
3. **Verify File Permissions**: The Dockerfile should have proper file permissions in your repo

## Expected Build Process

With the correct configuration, you should see in the build logs:
1. Docker building with your custom Dockerfile
2. Yarn install (not npm install)
3. Composer install with --no-scripts
4. Assets building with yarn build
5. Container starting successfully
6. Post-deployment commands running after container is up 