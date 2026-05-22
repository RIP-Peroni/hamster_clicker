#!/bin/sh
set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q "^APP_KEY=" .env || [ -z "$(grep "^APP_KEY=" .env | cut -d '=' -f2)" ]; then
    php artisan key:generate --force
fi

echo "Waiting for database..."
while ! pg_isready -h db -p 5432 -U hamster_user; do
    sleep 1
done

php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host=0.0.0.0 --port=8000