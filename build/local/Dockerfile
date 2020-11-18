ARG VERSION="7.4.12-fpm"
FROM php:${VERSION}

RUN apt-get update && apt-get install -y --no-install-recommends \
    git-core \
    unzip \
    libssl-dev \
    libicu-dev \
    libzip-dev \
    libevent-dev \
    imagemagick \
    libpng-dev \
    ffmpeg \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-install -j$(nproc) zip opcache intl sockets pcntl pdo pdo_mysql bcmath gd \
    && pecl update-channels \
    && pecl install APCu event ds redis \
    && docker-php-ext-enable apcu event ds redis \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

## Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug && docker-php-ext-enable xdebug && rm -rf /tmp/* /var/tmp/*

RUN useradd --create-home --uid 1000 --user-group --system app

ARG OPCACHE_DIR=/tmp/php-opcache
RUN mkdir ${OPCACHE_DIR} && chmod -R 777 ${OPCACHE_DIR}

## Configure PHP
COPY ./build/local/php /usr/local/etc/php

## Install application:
WORKDIR /opt/app

USER app

COPY --chown=app:app ./build/local/entrypoint.sh /home/app/entrypoint.sh

CMD /home/app/entrypoint.sh