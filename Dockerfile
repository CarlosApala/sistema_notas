# Etapa 1: PHP base con Laravel y Composer
FROM php:8.1-fpm as php-base

RUN apt-get update && apt-get install -y \
    libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar todo el código fuente
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader


# Etapa 2: Build de assets
FROM node:18 as node-build

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

# Copiar todo el proyecto desde php-base (incluye vendor)
COPY --from=php-base /var/www/html ./

# Build de Vite (esto generará public/build)
RUN npm run build


# Etapa 3: Contenedor final con PHP-FPM
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el código PHP (con vendor) desde php-base
COPY --from=php-base /var/www/html /var/www/html

# Copiar los assets compilados desde node-build
COPY --from=node-build /app/public/build /var/www/html/public/build

# Permisos para Laravel
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["php-fpm"]
