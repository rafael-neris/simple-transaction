docker-compose exec -T app composer install
docker-compose exec app php artisan migrate --seed