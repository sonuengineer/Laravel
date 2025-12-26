#!/bin/sh

echo "Running Laravel migrations..."
php artisan migrate --force || true

echo "Starting Apache..."
exec "$@"
