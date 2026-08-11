FROM php:8.4-cli
COPY . /app
WORKDIR /app
CMD php artisan serve --host=0.0.0.0 --port=$PORT