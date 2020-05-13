FROM php:7.4.5-fpm-buster

ENV COMPOSER_NO_INTERACTION 1
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /usr/src

RUN apt-get update \
    && apt-get install -y apt-utils wget \
        libzip-dev libjpeg62-turbo-dev libpng-dev libwebp-dev \
    && docker-php-ext-install zip pdo_mysql pcntl sockets \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && rm -rf /tmp/* /var/tmp/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '"$(wget -q -O - https://composer.github.io/installer.sig)"') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

ADD etc /usr/local/etc

WORKDIR /var/www

EXPOSE 9000