#!/usr/bin/env bash
set -e

# clear cache biar gak kejebak config lama
php artisan optimize:clear || true

# buat sqlite file (Render free: /tmp itu writable)
touch /tmp/database.sqlite

# migrate (kalau belum ada tabel)
php artisan migrate --force || true

# start apache
exec apache2-foreground
