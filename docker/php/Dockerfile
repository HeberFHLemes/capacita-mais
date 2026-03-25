FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    git \
    unzip \
    curl \
    libzip-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress

COPY . .