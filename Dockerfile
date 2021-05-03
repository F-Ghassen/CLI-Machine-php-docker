FROM php:7.4-fpm

RUN apt-get update -y && apt-get install -y openssl \
    zip \
    unzip \
    git \
    libmcrypt-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

COPY . /app

RUN composer install

EXPOSE 8000
