FROM php:8.2-apache

# Set working directory
WORKDIR /var/www

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files to working directory
COPY . /var/www

# Install necessary libraries
RUN apt-get update && apt-get install -y \
    git \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    pkg-config \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql gettext intl gd \
    && apt-get clean

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set permissions for the Laravel application
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Add wait-for-it script for service readiness
RUN curl -o /usr/local/bin/wait-for-it.sh https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh && \
    chmod +x /usr/local/bin/wait-for-it.sh
