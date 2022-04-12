FROM php:8.0-fpm

RUN apt update && apt install -y git zip
RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/gilded-rose-kata/