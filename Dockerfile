FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 🔥 THIS FIXES THE 404 ISSUE
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

RUN chmod -R 777 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
