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

# Instalar dependencias de PHP sin entorno de desarrollo para ahorrar memoria
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto que Render asigna dinámicamente
ENV PORT=10000
EXPOSE 10000

# Iniciar Laravel apuntando al puerto correcto
CMD php artisan serve --host=0.0.0.0 --port=10000