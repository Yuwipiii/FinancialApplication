FROM php:8.2-fpm-alpine

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

#Copy composer.json
COPY composer.json /var/www/

#Set working directory
WORKDIR /var/www

#Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libonig-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \

#Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
# Copy existing application directory permissions
COPY . /var/www
COPY .env.docker .env
RUN chown www:www -R /var/www/
RUN cd /var/www/ && composer install
RUN ls -la /var/www | grep vendor
RUN chmod 777 -R /var/www/bootstrap/
RUN chmod 777 -R /var/www/storage/
# Change current user to www
USER www
# Expose port 9000 and start php-fpm server
EXPOSE 9000
RUN ls -la
CMD ["php-fpm"]
