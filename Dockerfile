# ====== Build assets (Vite) ======
FROM node:20-alpine AS nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ====== PHP runtime ======
FROM php:8.3-apache

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libicu-dev \
  && docker-php-ext-install pdo_mysql zip intl \
  && a2enmod rewrite headers \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app
COPY . .

# Copy built assets
COPY --from=nodebuild /app/public/build /var/www/html/public/build

# Apache docroot -> /public
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Permissions (storage & cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP deps (no dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel optimize (opsional)
RUN php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

EXPOSE 80
