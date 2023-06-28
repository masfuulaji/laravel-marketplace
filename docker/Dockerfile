FROM php:8.2.7-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    git \
    zip \
    unzip \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql pgsql zip exif pcntl
RUN docker-php-ext-install opcache gd

COPY . /var/www/html

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 9000
CMD ["php-fpm"]
