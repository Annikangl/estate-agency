FROM php:8.0.2-fpm

RUN apt-get update && apt-get upgrade -y \
    && apt-get install apt-utils -y \
    && apt-get install git zip vim libzip-dev libgmp-dev libffi-dev libssl-dev -y \
    && docker-php-ext-install -j$(nproc) sockets zip gmp pcntl bcmath ffi pdo_mysql \
    && docker-php-source delete \
    && apt-get autoremove --purge -y \
    && apt-get autoclean -y \
    && apt-get clean -y


WORKDIR /var/www
