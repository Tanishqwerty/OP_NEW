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
    echo "- Manifest file size: $(stat -c%s public/build/manifest.json 2>/dev/null || echo "Unknown") bytes"
    echo "- Build assets count: $(find public/build -type f | wc -l) files"
else
    echo "- ❌ Manifest file missing"
    echo "- Attempting to rebuild assets..."
    if command -v yarn &> /dev/null; then
        yarn build && echo "✅ Assets rebuilt successfully" || echo "❌ Asset rebuild failed"
    else
        echo "❌ Yarn not available"
    fi
fi

echo ""
echo "🔧 Quick Fixes:"
echo "1. If manifest is missing: yarn build"
echo "2. If database fails: php artisan migrate --force"
echo "3. If routes fail: php artisan route:clear"
echo "4. If config issues: php artisan config:clear && php artisan config:cache"

echo ""
echo "Debug completed at $(date)" 