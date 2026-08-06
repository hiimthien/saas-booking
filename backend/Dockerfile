FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql bcmath gd zip pcntl

WORKDIR /var/www/html

COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 8000

RUN chmod +x frankenphp

# Use artisan octane for extreme local performance on Windows
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
