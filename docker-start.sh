#!/usr/bin/env bash
set -e

APP_DIR="/var/www/html"

echo "==> Booting Laravel on Render..."
echo "==> APP_URL=${APP_URL:-"(not set)"}"
echo "==> ASSET_URL=${ASSET_URL:-"(not set)"}"
echo "==> DB_CONNECTION=${DB_CONNECTION:-"(not set)"}"
echo "==> DB_DATABASE=${DB_DATABASE:-"(not set)"}"

# 1) Pastikan folder storage lengkap
mkdir -p "$APP_DIR/storage/framework/cache"
mkdir -p "$APP_DIR/storage/framework/data"
mkdir -p "$APP_DIR/storage/framework/sessions"
mkdir -p "$APP_DIR/storage/framework/views"
mkdir -p "$APP_DIR/storage/logs"
mkdir -p "$APP_DIR/bootstrap/cache"

# 2) Folder sqlite
mkdir -p "$APP_DIR/storage/database"

# 3) Buat file sqlite kalau belum ada
if [ "${DB_CONNECTION}" = "sqlite" ]; then
  if [ ! -f "$APP_DIR/storage/database/database.sqlite" ]; then
    echo "==> Creating SQLite database file..."
    touch "$APP_DIR/storage/database/database.sqlite"
  fi
fi

# 4) Permission
chown -R www-data:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" || true
chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" || true

# (optional) pastikan public/build bisa dibaca
chown -R www-data:www-data "$APP_DIR/public/build" 2>/dev/null || true
chmod -R 755 "$APP_DIR/public/build" 2>/dev/null || true

# 5) Clear cache biar env Render kebaca
php artisan optimize:clear || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# 6) Migrasi
php artisan migrate --force || true

# 7) CHECK VITE BUILD OUTPUT (WAJIB sebelum apache start)
echo "=== CHECK BUILD OUTPUT ==="
ls -lah "$APP_DIR/public/build" || true
ls -lah "$APP_DIR/public/build/assets" || true

echo "=== CHECK MANIFEST ==="
if [ -f "$APP_DIR/public/build/manifest.json" ]; then
  head -n 40 "$APP_DIR/public/build/manifest.json" || true
else
  echo "!! manifest.json NOT FOUND -> @vite() pasti 404"
fi

echo "==> Starting Apache..."
exec apache2-foreground
