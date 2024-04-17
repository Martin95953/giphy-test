FROM php:8.2.11-fpm

# Instalar extensiones y dependencias de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsodium-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-enable sodium

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#
WORKDIR /var/www

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#
COPY ../../composer.json ./

# Run composer i
RUN composer install --no-plugins --no-scripts --prefer-dist

RUN chmod 644 /storage/oauth-*.key
