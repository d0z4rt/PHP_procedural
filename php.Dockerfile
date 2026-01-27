FROM php:fpm

RUN apt-get update && \
    apt-get install -y libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql mysqli soap

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /app