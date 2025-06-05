# Laravel Order Processing System - Deployment Fixes

## Issues Resolved

### 1. Database Migration Conflicts ✅
**Problem**: `SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'products' already exists`

**Root Cause**: The database already had some tables created, but migrations were trying to create them again.

**Solution Applied**:
- Modified all pending migration files to check if tables exist before creating them
- Updated migrations: `products`, `orders`, `warehouses`, `cities`
- Added `Schema::hasTable()` checks to prevent conflicts

**Files Modified**:
- `database/migrations/2025_04_23_080231_create_products_table.php`
- `database/migrations/2025_04_24_094552_create_orders_table.php`
- `database/migrations/2025_04_25_063609_create_warehouses_table.php`
- `database/migrations/2025_05_13_070221_create_cities_table.php`

### 2. Vite Manifest Path Mismatch ✅
**Problem**: `Vite manifest not found at: /var/www/html/public/build/manifest.json`

**Root Cause**: Vite was building the manifest to `public/build/.vite/manifest.json` but Laravel was looking for it at `public/build/manifest.json`.

**Solution Applied**:
- Enhanced Dockerfile to copy manifest from `.vite` subdirectory to expected location
- Added runtime checks to fix manifest path after rebuilds
- Updated debug script to detect and fix this specific issue
- Ensured proper permissions for build directory

**Files Modified**:
- `Dockerfile` - Added manifest path fix during build and runtime
- `vite.config.js` - Improved configuration for Laravel compatibility
- `debug-deployment.sh` - Added specific checks for manifest path issues

## Deployment Steps

### 1. Push Changes to Repository
```bash
git add .
git commit -m "Fix database migration conflicts and Vite manifest path issues"
git push origin main
```

### 2. Deploy in Coolify
1. Go to your application in Coolify
2. Click "Deploy"
3. Enable "Force rebuild" to ensure clean build
4. Monitor build logs for successful asset compilation

### 3. Verify Deployment
After deployment, check these endpoints:
- `/test` - Should show "Laravel is working!"
- `/debug` - Should show system status including database connection
- `/login` - Should load with proper CSS styling

## Expected Build Process

The build should now show:
```
✓ 366 modules transformed.
rendering chunks...
computing gzip size...
public/build/.vite/manifest.json     8.51 kB │ gzip: 1.22 kB
[... other assets ...]
```

**Important**: The manifest will be automatically copied from `public/build/.vite/manifest.json` to `public/build/manifest.json` where Laravel expects it.

## Migration Status After Fix

Run `php artisan migrate:status` should show:
```
Migration name .............................................. Batch / Status  
0001_01_01_000000_create_users_table ............................... [1] Ran  
0001_01_01_000001_create_cache_table ............................... [1] Ran  
0001_01_01_000002_create_jobs_table ................................ [1] Ran  
2025_04_14_064536_create_roles_table ............................... [1] Ran  
2025_04_17_085947_create_shades_table .............................. [2] Ran  
2025_04_17_085957_create_patterns_table ............................ [2] Ran  
2025_04_17_090007_create_sizes_table ............................... [2] Ran  
2025_04_17_090014_create_embroidery_options_table .................. [2] Ran  
2025_04_23_080231_create_products_table ............................ [3] Ran  
2025_04_24_094552_create_orders_table .............................. [3] Ran  
2025_04_25_063609_create_warehouses_table .......................... [3] Ran  
2025_05_13_070221_create_cities_table .............................. [3] Ran  
```

## Troubleshooting

### If Vite Manifest Path Issue Persists
```bash
# Check if manifest exists in .vite subdirectory
ls -la public/build/.vite/manifest.json

# Copy manifest to expected location
cp public/build/.vite/manifest.json public/build/manifest.json

# Verify Laravel can now find it
php artisan route:list
```

### If Assets Still Missing
```bash
# SSH into container and run:
yarn build

# Then fix manifest path:
cp public/build/.vite/manifest.json public/build/manifest.json
```

### If Database Issues Persist
```bash
# Check migration status:
php artisan migrate:status

# Force run migrations:
php artisan migrate --force
```

### If Routes Still Have Issues
```bash
# Clear route cache:
php artisan route:clear

# Clear all caches:
php artisan config:clear
php artisan view:clear
```

## Debug Script Usage

A debug script has been created at `debug-deployment.sh`. To use it:

```bash
# Make executable
chmod +x debug-deployment.sh

# Run debug check
./debug-deployment.sh
```

This will check:
- Environment variables
- File system status
- Database connectivity
- Asset compilation status
- **Vite manifest path issues** (NEW)
- Web server status

The script will automatically detect and fix the manifest path issue if found.

## Environment Variables Required

Ensure these are set in Coolify:
```
APP_NAME=Laravel_Order_Processing
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:x+4XDWw4wqXoRbTnonNcd6m51od70nFuOHc5smUqvOI=
APP_URL=https://orderprocessing.divinecareindustries.com/
DB_CONNECTION=mysql
DB_HOST=nowk4scs88k0g0w8wck88gsc
DB_PORT=3306
DB_DATABASE=default
DB_USERNAME=divinecare_user
DB_PASSWORD=Wy2tD4dlmD6hFbKjQQBWHfuIY45PXjQvCDc750Hs5x14oRfTtF3qqs4j0dUIr5w8
```

## Expected Results

After applying these fixes:
- ✅ Database migrations will run without conflicts
- ✅ Vite manifest will be available at the correct path
- ✅ CSS and JavaScript assets will load properly
- ✅ Login page will display with proper styling
- ✅ Application will be fully functional

## Next Steps

1. Deploy with the fixes
2. Test all major routes
3. Verify database functionality
4. Test user authentication flow
5. Monitor application logs for any remaining issues

The application should now be fully operational with proper styling and database connectivity.

## Quick Fix Commands

If you need to manually fix the manifest issue after deployment:

```bash
# SSH into the container
docker exec -it <container_name> bash

# Copy manifest to expected location
cp /var/www/html/public/build/.vite/manifest.json /var/www/html/public/build/manifest.json

# Restart Apache (if needed)
service apache2 restart
``` 