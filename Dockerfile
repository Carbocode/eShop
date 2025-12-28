FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first to leverage cache
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy application source
COPY . /var/www/html/

# Set permissions if necessary (e.g. for upload directories)
# RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
