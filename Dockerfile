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

# Игнорируем требования к версии PHP
RUN composer install --optimize-autoloader --no-dev --ignore-platform-req=php

# Создаем и настраиваем БД
RUN touch database/database.sqlite && chmod 777 database/database.sqlite

RUN chown -R www-data:www-data storage bootstrap/cache database
RUN chmod -R 775 storage bootstrap/cache
RUN chmod -R 777 database

# Выполняем миграции
RUN php artisan migrate --force

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]