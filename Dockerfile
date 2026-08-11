FROM php:8.4-cli

# Instalar dependencias del sistema esenciales
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código del proyecto al contenedor
COPY . /app
WORKDIR /app

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Crear la base de datos SQLite si no existe y dar permisos totales a storage y database
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache database \
    && touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database

# Exponer el puerto
ENV PORT=10000
EXPOSE 10000

# Ejecutar migraciones y luego iniciar el servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000