FROM php:8.1

# set correct timezone
RUN echo "Europe/Berlin" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

RUN usermod -u 1000 www-data
RUN apt update && apt upgrade -y && apt install -y git unzip zlib1g-dev libbz2-dev libfontconfig libzip-dev zip libicu-dev g++

RUN docker-php-ext-install zip
RUN docker-php-ext-install bz2
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
#RUN docker-php-ext-install opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

