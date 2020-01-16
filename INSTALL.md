composer install --optimize-autoloader

=> Configure .env file

php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan migrate:fresh
