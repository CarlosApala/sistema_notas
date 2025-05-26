# Usa la imagen oficial PHP 8 con FPM (más común para Laravel)
FROM php:8.1-fpm

# Instala dependencias de sistema necesarias y el driver de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer globalmente (desde la imagen oficial de Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia todo el código fuente al contenedor
COPY . .

# Instala las dependencias PHP del proyecto (sin paquetes de desarrollo)
RUN composer install --no-dev --optimize-autoloader

# Exponer puerto (solo si usas php-fpm con un proxy, generalmente 9000)
EXPOSE 9000

# Comando para ejecutar PHP-FPM
CMD ["php-fpm"]
