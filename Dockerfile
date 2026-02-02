# =========================
# 1) Build frontend assets
# =========================
FROM node:20-alpine AS nodebuild
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# =========================
# 2) PHP + Apache runtime
# =========================
FROM php:8.2-apache

# Apache: pastikan hanya 1 MPM aktif (untuk mod_php wajib prefork)
RUN a2dismod mpm_event mpm_worker || true \
 && a2enmod mpm_prefork

# OS deps + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j"$(nproc)" \
      pdo_mysql \
      zip \
      intl \
      mbstring \
      bcmath \
      exif \
      gd \
  && a2enmod rewrite headers \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app source
COPY . .

# Copy built Vite assets
COPY --from=nodebuild /app/public/build /var/www/html/public/build

# Apache docroot -> /public
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Install PHP deps (prod)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions (Laravel)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Optional caches (aman walau env belum lengkap)
RUN php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

EXPOSE 80