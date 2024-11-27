# Wait for the database to be ready
echo "Checking database host: ${DB_HOST}, port: ${DB_PORT}"
wait-for-it.sh ${DB_HOST}:${DB_PORT} --timeout=30 --strict -- echo "Database is ready!"

# Run Composer commands
composer install
composer update

# Run Laravel commands
php artisan optimize
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

apache2-foreground
