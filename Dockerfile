FROM php:7.2-fpm

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

RUN apt-get update && apt-get install -y \
    git \
    zip

RUN apt-get install -y \
        libfreetype6-dev \
    && docker-php-ext-install -j$(nproc) iconv

RUN docker-php-ext-install -j$(nproc) \
    opcache \
    pdo_mysql \
    zip

RUN apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

EXPOSE 9000

CMD ["php-fpm", "-F"]
