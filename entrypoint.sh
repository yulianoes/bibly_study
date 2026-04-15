#!/bin/bash

echo "🚀 Iniciando Laravel (Stateless Mode)..."

# Garantir permissões apenas para o que for estritamente necessário
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Limpar e gerar caches (usando driver 'array' definido no .env)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Link de storage
php artisan storage:link || true

echo "✅ App pronta para o Render!"

exec "$@"