FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql

RUN apt-get install -y ssmtp

COPY php.ini /usr/local/etc/php
COPY ssmtp.conf /etc/ssmtp/ssmtp.conf
COPY revaliases /etc/ssmtp/revaliases
COPY ssmtp.env  /etc/ssmtp/ssmtp.env

COPY ssmtp.sh /etc/ssmtp/ssmtp.sh
RUN chmod 777 /etc/ssmtp/ssmtp.sh
RUN /etc/ssmtp/ssmtp.sh

WORKDIR /app
