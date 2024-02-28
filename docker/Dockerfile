FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y git libpq-dev
RUN docker-php-ext-install pdo_pgsql

COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash

WORKDIR /var/www
COPY . /var/www

RUN composer install

CMD ["php-fpm"]