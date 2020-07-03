# docker-laravel-handson

## DB Setup

```bash
docker-compose exec app php artisan migrate:fresh
docker-compose exec app php artisan db:seed
```
