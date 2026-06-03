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

# Создаем папки для фото
RUN mkdir -p storage/app/public/products storage/app/public/categories storage/app/public/news

# Копируем фото из репозитория
COPY storage/app/public/products /var/www/html/storage/app/public/products
COPY storage/app/public/categories /var/www/html/storage/app/public/categories
COPY storage/app/public/news /var/www/html/storage/app/public/news

# Копируем существующую БД из репозитория
COPY database/database.sqlite /var/www/html/database/database.sqlite

# Настраиваем права
RUN chown -R www-data:www-data storage bootstrap/cache database
RUN chmod -R 775 storage bootstrap/cache
RUN chmod -R 777 database
RUN chmod -R 777 storage/app/public

# Выполняем миграции только если нет таблиц
RUN php artisan migrate --force || true

EXPOSE 10000

# Очищаем кэш при старте
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]