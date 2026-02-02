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
RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
 && a2enconf servername

# --- Apache MPM fix (bandel-proof, SYNTAX BENAR) ---
RUN set -eux; \
  cat > /usr/local/bin/fix-mpm.sh <<'SH'
#!/bin/sh
set -eu

# Matikan semua MPM
a2dismod -f mpm_event mpm_worker mpm_prefork >/dev/null 2>&1 || true

# Bersihkan symlink bandel
rm -f /etc/apache2/mods-enabled/mpm_event.* \
      /etc/apache2/mods-enabled/mpm_worker.* \
      /etc/apache2/mods-enabled/mpm_prefork.* || true

# Aktifkan prefork saja (wajib mod_php)
a2enmod mpm_prefork >/dev/null 2>&1 || true
a2enmod rewrite headers >/dev/null 2>&1 || true

# Debug (optional)
apache2ctl -M 2>/dev/null | grep mpm || true

exec apache2-foreground
SH
RUN chmod +x /usr/local/bin/fix-mpm.sh


# --- OS deps + PHP extensions ---
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip \
    pkg-config \
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
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# App source
COPY . .

# Vite build
COPY --from=nodebuild /app/public/build /var/www/html/public/build

# Apache docroot → /public
RUN sed -i 's#/var/www/html#/var/www/html/public#g' \
    /etc/apache2/sites-available/000-default.conf

# PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Optional caches
RUN php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

EXPOSE 80

CMD ["/usr/local/bin/fix-mpm.sh"]
