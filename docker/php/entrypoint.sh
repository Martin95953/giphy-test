#!/bin/bash
set -e

# Ejecutar migraciones y configuraciones de Laravel
php artisan migrate
php artisan passport:install
php artisan migrate --env=testing
php artisan passport:install --env=testing

# Ajustar permisos
chmod 644 /var/www/storage/oauth-*.key

php-fpm
