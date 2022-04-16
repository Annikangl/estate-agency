FROM php:8.0.2-cli

RUN apt-get update && apt-get upgrade -y \
    && apt-get install apt-utils -y \

#   устанавливаем необходимые пакеты
    && apt-get install git zip vim libzip-dev libgmp-dev libffi-dev libssl-dev -y \

#   Включаем необходимые расширения
    && docker-php-ext-install -j$(nproc) sockets zip gmp pcntl bcmath ffi pdo_mysql \

#    Чистим временные файлы
    && docker-php-source delete \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y

WORKDIR /var/www
