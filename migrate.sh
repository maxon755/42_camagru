#!/usr/bin/env bash

docker-compose exec php-fpm /bin/bash -c 'cd config; php setup.php'