#!/usr/bin/env bash
set -e

APP_DIR="/var/www/html"

echo "==> Booting Laravel on Render..."

# 1) Pastikan folder storage lengkap (ini yang bikin error kamu: sessions/views/cache gak ada)
mkdir -p $APP_DIR/storage/framework/{cache,data,sessions,views}
mkdir -p $APP_DIR/storage/logs
mkdir -p $APP_DIR/bootstrap/cache

# 2) (Optional) bikin folder khusus sqlite biar rapi
mkdir -p $APP_DIR/storage/database

# 3) Kalau DB sqlite belum ada, buat file sqlite-nya
if [ "$DB_CONNECTION" = "sqlite" ]; then
  if [ ! -f "$APP_DIR/storage/database/database.sqlite" ]; then
    echo "==> Creating SQLite database file..."
    touch $APP_DIR/storage/database/database.sqlite
  fi
fi

# 4) Permission biar Apache bisa nulis session/cache/view/sqlite
chown -R www-data:www-data $APP_DIR/storage $APP_DIR/bootstrap/cache
chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache

# 5) Bersihkan cache supaya ENV Render yang baru kebaca
php artisan optimize:clear || true

# 6) Cache ulang config/route/view (optional tapi bikin cepat)
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# 7) Jalankan migrate otomatis (aman kalau sqlite sudah ada)
php artisan migrate --force || true

echo "==> Starting Apache..."
exec apache2-foreground
