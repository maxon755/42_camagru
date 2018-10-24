FROM php:7.2-fpm

WORKDIR /app

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql

