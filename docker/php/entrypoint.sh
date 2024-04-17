#!/bin/bash
set -e

# Ejecutar migraciones y configuraciones de Laravel
php artisan migrate
php artisan passport:install

# Ajustar permisos
chmod 644 /var/www/storage/oauth-*.key

php-fpm
