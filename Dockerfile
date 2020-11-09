FROM php:7.3-fpm-alpine

RUN apk update \
    && \
    apk add \
    git \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

RUN docker-php-ext-configure \
    gd -with-png-dir=/usr/include/ -with-jpeg-dir=/usr/include/ -with-freetype-dir=/usr/include/

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    gd

RUN mkdir -p /vaw/www/api

WORKDIR /var/www/api

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"

COPY . .

RUN php composer.phar install
