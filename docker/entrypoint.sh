#!/bin/sh
set -e

cd /var/www/html

# Container Apps menyuntikkan konfigurasi lewat environment variables
# (Application Settings / --env-vars), bukan file .env — Laravel tetap bisa
# membacanya langsung lewat env() karena getenv() sudah terisi oleh container
# runtime, tapi cache config di bawah butuh var itu SUDAH ada saat container
# start (bukan saat image di-build), makanya di-cache di sini, bukan di Dockerfile.

echo "[entrypoint] Menjalankan migrasi database..."
php artisan migrate --force --no-interaction || echo "[entrypoint] Migrasi gagal/lewati (cek DB env vars)."

echo "[entrypoint] Membuat symlink storage..."
php artisan storage:link || true

echo "[entrypoint] Cache config/route/view..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[entrypoint] Siap. Menjalankan Apache..."
exec "$@"
