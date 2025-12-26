FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 777 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
