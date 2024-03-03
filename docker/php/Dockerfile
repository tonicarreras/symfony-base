FROM php:8.3-fpm-alpine

# PHP 8.3 xdebug version
ENV XDEBUG_VERSION=3.3.0

# Update and upgrade apk packages, then install necessary dependencies
RUN apk --update upgrade \
    && apk add --no-cache \
    autoconf \
    automake \
    make \
    gcc \
    g++ \
    git \
    bash \
    icu-dev \
    libzip-dev \
    linux-headers \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-install \
    zip  \
    pdo  \
    bcmath \
    opcache \
    intl \
    pdo_mysql \
    mbstring \
    && pecl install  \
    xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable  \
    xdebug

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash -s - --install-dir /usr/local/bin

WORKDIR /var/www/html

