# Usa la imagen oficial PHP 8 con FPM
FROM php:8.1-fpm

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . .

RUN npm install && npm run build


# Instala dependencias PHP del proyecto
RUN composer install --no-dev --optimize-autoloader

# Expone el puerto correcto para Laravel (built-in server)
EXPOSE 8080

# Ejecuta Laravel en el servidor interno
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
