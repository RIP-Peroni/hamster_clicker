#!/bin/sh
set -e

echo "=== Starting Hamster Clicker ==="

if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

if ! grep -q "^APP_KEY=" .env || [ -z "$(grep "^APP_KEY=" .env | cut -d '=' -f2)" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "Waiting for database..."
for i in $(seq 1 30); do
    if php artisan migrate:status > /dev/null 2>&1; then
        break
    fi
    sleep 1
done

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

echo "Starting server on port 8000..."
exec php artisan serve --host=0.0.0.0 --port=8000