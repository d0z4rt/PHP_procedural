FROM php:fpm

RUN apt-get update && \
    apt-get install -y libxml2-dev git unzip

RUN docker-php-ext-install pdo pdo_mysql mysqli soap

RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /app
