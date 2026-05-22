# FROM php:8.4-fpm-alpine
FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    git \
    unzip \
    curl \
    libzip-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY src/ ./src/
COPY scripts/ ./scripts/
COPY public/index.php ./public/index.php
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress

# pelo menos por enquanto (desenvolvimento)...
CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]