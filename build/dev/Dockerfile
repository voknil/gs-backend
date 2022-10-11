ARG VERSION="8.1.9-fpm"
FROM php:${VERSION}

RUN apt-get update && apt-get install -y --no-install-recommends \
    git-core \
    unzip \
    libssl-dev \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libxml2-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) zip opcache intl pdo pdo_pgsql sockets pcntl bcmath \
    && pecl update-channels \
    && pecl install APCu ds \
    && docker-php-ext-enable apcu ds \
    &&  rm -rf /tmp/pear \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

## Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Create user
RUN useradd --create-home --uid 1000 --user-group --system app

##php config
COPY ./build/local/php.ini /usr/local/etc/php
COPY ./build/local/php-fpm.ini /usr/local/etc/php-fpm.d/zzz-docker.conf

WORKDIR /opt/app

## Install application:
RUN chown -R app:app .

COPY --chown=app:app composer.json composer.json
COPY --chown=app:app composer.lock composer.lock
COPY --chown=app:app symfony.lock  symfony.lock

### Install xdebug
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

USER app

ARG OPCACHE_DIR=/tmp/php-opcache
RUN mkdir -p var/cache \
    && mkdir -p var/log \
    && mkdir -p var/jwt \
    && chmod -R 0777 var \
    && mkdir -p ${OPCACHE_DIR} \
    && chmod -R 0700 ${OPCACHE_DIR}

RUN composer install \
    --no-interaction \
    --no-ansi \
    --no-progress \
    --optimize-autoloader \
    --apcu-autoloader \
    --prefer-dist \
    --no-scripts \
    --no-dev \
    && rm -rf ~/.composer/cache/*

COPY --chown=app:app bin                bin
COPY --chown=app:app public             public
COPY --chown=app:app config             config
COPY --chown=app:app src                src