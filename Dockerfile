# Etapa 1: Construcción de dependencias y assets
FROM node:18 as node-build

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .

RUN npm run build

# Etapa 2: PHP con Laravel
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia todos los archivos de proyecto excepto node_modules y public/build
COPY . .

# Copia la carpeta public/build generada en el stage node-build
COPY --from=node-build /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
