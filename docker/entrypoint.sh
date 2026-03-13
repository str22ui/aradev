#!/bin/sh
set -e

if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    echo "✅ .env dibuat"
fi

sed -i 's/DB_HOST=.*/DB_HOST=db/' /var/www/html/.env
sed -i 's/DB_PORT=.*/DB_PORT=3306/' /var/www/html/.env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=u433934007_aradev/' /var/www/html/.env
sed -i 's/DB_USERNAME=.*/DB_USERNAME=aradev/' /var/www/html/.env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=secret/' /var/www/html/.env

chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

php artisan key:generate --no-interaction --force
php artisan config:clear
php artisan cache:clear
php artisan storage:link --force


echo "✅ Aradev siap! Buka http://localhost:8000"

php-fpm &
nginx -g "daemon off;"
