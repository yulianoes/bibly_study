#!/bin/bash

echo "🚀 Iniciando Laravel..."

# Garantir permissões
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Limpar caches antes de gerar novos
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache para performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Rodar migrações automaticamente (importante para Render/Produção)
php artisan migrate --force

# Storage link
php artisan storage:link || true

echo "✅ Laravel pronto!"

exec "$@"