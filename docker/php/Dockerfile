FROM php:8.3-fpm-alpine AS build

# Определяем аргументы user и uid, которые можно передать при сборке образа
ARG user
ARG uid

RUN apk add --no-cache \
    autoconf \
    g++ \
    make \
    libzip-dev \
    postgresql-dev \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    unzip \
    imap-dev \
    krb5-dev \
    openssh-client \
    git \
    curl \
    bash \
    tzdata \
    mysql-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip soap xml imap \
    && pecl update-channels \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis imap \
    && apk del $PHPIZE_DEPS \
    && rm -rf /tmp/pear

# Копируем установщик расширений PHP из другого образа
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN adduser -D -u $uid -h /home/$user $user \
    && addgroup $user www-data \
    && addgroup $user root

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Копируем кастомный php.ini
COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/api

USER $user