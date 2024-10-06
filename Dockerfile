# Use the official PHP image with Apache
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo mbstring exif pcntl bcmath gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Set the correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set up Apache to serve the Laravel backend from /var/www/html/public
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Run Laravel queue worker (Optional, can be skipped if queues aren't used)
# CMD php artisan queue:work --daemon

# Start Apache server
CMD ["apache2-foreground"]
