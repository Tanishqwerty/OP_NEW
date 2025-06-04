#!/bin/bash

echo "🔍 Docker Build Debug Script"
echo "=============================="

echo "📋 Checking project structure..."
echo "- Dockerfile exists: $(test -f Dockerfile && echo "✅" || echo "❌")"
echo "- composer.json exists: $(test -f composer.json && echo "✅" || echo "❌")"
echo "- package.json exists: $(test -f package.json && echo "✅" || echo "❌")"
echo "- yarn.lock exists: $(test -f yarn.lock && echo "✅" || echo "❌")"
echo "- artisan exists: $(test -f artisan && echo "✅" || echo "❌")"

echo ""
echo "🐳 Building Docker image..."
docker build -t laravel-app-debug . --no-cache

echo ""
echo "🚀 If build succeeds, you can run:"
echo "docker run -p 8000:80 laravel-app-debug" 