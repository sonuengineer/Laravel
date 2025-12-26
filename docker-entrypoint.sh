#!/bin/sh

echo "Running Laravel migrations..."
php artisan migrate --force || true

php artisan db:seed --class=AdminUserSeeder || true

echo "Starting Apache..."
exec "$@"
