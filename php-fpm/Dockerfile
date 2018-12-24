FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql

RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug

RUN apt-get install -y ssmtp

COPY php.ini /usr/local/etc/php

COPY php-camagru-entrypoint /usr/local/bin

WORKDIR /app

ENTRYPOINT ["php-camagru-entrypoint"]
CMD ["php-fpm"]

