FROM php:8.2.0-cli
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html