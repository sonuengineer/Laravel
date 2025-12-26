#!/bin/sh

echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true

echo "Running migrations..."
php artisan migrate --force || true

echo "Creating default users..."
php artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::updateOrCreate(
  ['email' => 'admin@test.com'],
  [
    'name' => 'Admin',
    'password' => Hash::make('password'),
    'role' => 'admin'
  ]
);

User::updateOrCreate(
  ['email' => 'user1@test.com'],
  [
    'name' => 'User One',
    'password' => Hash::make('password'),
    'role' => 'user'
  ]
);

User::updateOrCreate(
  ['email' => 'user2@test.com'],
  [
    'name' => 'User Two',
    'password' => Hash::make('password'),
    'role' => 'user'
  ]
);
" || true

echo "Starting Apache..."
exec "$@"
