FROM php:8.0.13-fpm-alpine3.15

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    zlib-dev \
    libpng-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer