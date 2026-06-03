FROM php:8.5-apache

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    git \
    unzip \
    && docker-php-ext-install pdo_sqlite

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --optimize-autoloader --no-dev --ignore-platform-req=php

RUN mkdir -p storage/app/public/products storage/app/public/categories storage/app/public/news

COPY storage/app/public/products /var/www/html/storage/app/public/products
COPY storage/app/public/categories /var/www/html/storage/app/public/categories
COPY storage/app/public/news /var/www/html/storage/app/public/news

COPY database/database.sqlite /var/www/html/database/database.sqlite

# Правильные права доступа
RUN chown -R www-data:www-data storage bootstrap/cache database public
RUN chmod -R 775 storage bootstrap/cache
RUN chmod -R 775 database
RUN chmod -R 775 storage/app/public
RUN chmod -R 775 public

RUN php artisan migrate --force || true
RUN php artisan storage:link

RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]