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

# --- Apache MPM fix (bandel-proof) ---
RUN set -eux; \
  cat > /usr/local/bin/fix-mpm.sh <<'SH' \
#!/bin/sh
set -eu

# Matikan semua MPM (paksa)
a2dismod -f mpm_event mpm_worker mpm_prefork >/dev/null 2>&1 || true

# Hapus symlink mods-enabled yang sering bikin dobel
rm -f /etc/apache2/mods-enabled/mpm_event.* \
      /etc/apache2/mods-enabled/mpm_worker.* \
      /etc/apache2/mods-enabled/mpm_prefork.* || true

# Nyalakan prefork doang (wajib untuk mod_php)
a2enmod mpm_prefork >/dev/null 2>&1 || true

# Enable modul umum yang kamu butuh
a2enmod rewrite headers >/dev/null 2>&1 || true

# Debug (biar kelihatan kalau masih dobel)
apache2ctl -M 2>/dev/null | grep mpm || true

exec apache2-foreground
SH
  chmod +x /usr/local/bin/fix-mpm.sh

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

# Jalankan apache lewat script fix MPM
CMD ["/usr/local/bin/fix-mpm.sh"]
