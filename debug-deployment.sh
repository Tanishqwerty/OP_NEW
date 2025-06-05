#!/bin/bash

echo "🔍 Laravel Deployment Debug Script"
echo "=================================="

echo ""
echo "📋 Environment Check:"
echo "- APP_NAME: ${APP_NAME:-'Not Set'}"
echo "- APP_ENV: ${APP_ENV:-'Not Set'}"
echo "- APP_DEBUG: ${APP_DEBUG:-'Not Set'}"
echo "- APP_URL: ${APP_URL:-'Not Set'}"
echo "- DB_HOST: ${DB_HOST:-'Not Set'}"
echo "- DB_DATABASE: ${DB_DATABASE:-'Not Set'}"

echo ""
echo "📁 File System Check:"
echo "- .env exists: $(test -f .env && echo "✅" || echo "❌")"
echo "- artisan exists: $(test -f artisan && echo "✅" || echo "❌")"
echo "- composer.json exists: $(test -f composer.json && echo "✅" || echo "❌")"
echo "- package.json exists: $(test -f package.json && echo "✅" || echo "❌")"
echo "- public/build exists: $(test -d public/build && echo "✅" || echo "❌")"
echo "- public/build/manifest.json exists: $(test -f public/build/manifest.json && echo "✅" || echo "❌")"
echo "- public/build/.vite/manifest.json exists: $(test -f public/build/.vite/manifest.json && echo "✅" || echo "❌")"

echo ""
echo "🗄️  Database Check:"
if command -v php &> /dev/null; then
    echo "- Database connection: $(php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Connected'; } catch(Exception \$e) { echo 'Failed: ' . \$e->getMessage(); }" 2>/dev/null || echo "Failed to test")"
    echo "- Migration status:"
    php artisan migrate:status 2>/dev/null || echo "  ❌ Failed to get migration status"
else
    echo "- PHP not available for testing"
fi

echo ""
echo "🌐 Web Server Check:"
echo "- Apache status: $(systemctl is-active apache2 2>/dev/null || echo "Unknown")"
echo "- Port 80 listening: $(netstat -ln 2>/dev/null | grep ':80 ' && echo "✅" || echo "❌")"

echo ""
echo "📦 Asset Check:"
if [ -f "public/build/manifest.json" ]; then
    echo "- ✅ Manifest found at expected location: public/build/manifest.json"
    echo "- Manifest file size: $(stat -c%s public/build/manifest.json 2>/dev/null || echo "Unknown") bytes"
    echo "- Build assets count: $(find public/build -type f | wc -l) files"
    
    echo ""
    echo "🎨 CSS Files Check:"
    css_files=$(find public/build -name "*.css" | head -5)
    if [ -n "$css_files" ]; then
        echo "- CSS files found:"
        echo "$css_files" | while read file; do
            echo "  📄 $file ($(stat -c%s "$file" 2>/dev/null || echo "Unknown") bytes)"
        done
    else
        echo "- ❌ No CSS files found in build directory"
    fi
    
    echo ""
    echo "📋 Manifest Content (first 20 lines):"
    head -20 public/build/manifest.json | sed 's/^/  /'
    
elif [ -f "public/build/.vite/manifest.json" ]; then
    echo "- ⚠️  Manifest found in .vite subdirectory but not at expected location"
    echo "- Copying manifest to expected location..."
    cp public/build/.vite/manifest.json public/build/manifest.json && echo "✅ Manifest copied successfully" || echo "❌ Failed to copy manifest"
else
    echo "- ❌ Manifest file missing from both locations"
    echo "- Attempting to rebuild assets..."
    if command -v yarn &> /dev/null; then
        yarn build && echo "✅ Assets rebuilt successfully" || echo "❌ Asset rebuild failed"
        # Check again after rebuild
        if [ -f "public/build/.vite/manifest.json" ]; then
            echo "- Copying manifest from .vite subdirectory..."
            cp public/build/.vite/manifest.json public/build/manifest.json && echo "✅ Manifest copied after rebuild" || echo "❌ Failed to copy manifest after rebuild"
        fi
    else
        echo "❌ Yarn not available"
    fi
fi

echo ""
echo "🔧 Quick Fixes:"
echo "1. If manifest is in .vite subdirectory: cp public/build/.vite/manifest.json public/build/manifest.json"
echo "2. If manifest is missing: yarn build"
echo "3. If CSS files missing: yarn build && cp public/build/.vite/manifest.json public/build/manifest.json"
echo "4. If database fails: php artisan migrate --force"
echo "5. If routes fail: php artisan route:clear"
echo "6. If config issues: php artisan config:clear && php artisan config:cache"

echo ""
echo "Debug completed at $(date)" 