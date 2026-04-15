#!/bin/bash

echo "🚀 Iniciando Laravel..."

# Garantir permissões
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link || true

echo "✅ Laravel pronto!"

exec "$@"