ARG PHP_VERSION
FROM php:${PHP_VERSION}

ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libssl-dev \ 
    libc-client-dev \
    libkrb5-dev  \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#Install extension

#Redis
RUN pecl install redis\
    && docker-php-ext-enable redis 
# Mongo + mailparse
RUN pecl install mongodb mailparse && \
    docker-php-ext-enable mongodb mailparse   
#imap
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install soap imap zip gd bcmath pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy custom configurations PHP
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# composer install
RUN cd /var/www/
COPY --chown=www-data:www-data ./app .
RUN rm -rf vendor
RUN composer install --no-interaction

#Config Supervisor
COPY ./docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/supervisord/supervisord.conf /etc/supervisord.d/

#Config Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
