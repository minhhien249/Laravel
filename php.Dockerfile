FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libzip-dev

# Extension zip for laravel
RUN docker-php-ext-install zip

# Install PHP extensions needed
RUN docker-php-ext-install -j$(nproc) mysqli pdo_mysql gd zip pcntl exif

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require laravel/installer