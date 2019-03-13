#!/usr/bin/env bash

chmod 777 app/storage/images

docker-compose exec php-fpm /bin/bash -c 'cd config; php setup.php'
