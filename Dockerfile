# Etapa 1: PHP base con Laravel y Composer
FROM php:8.1-fpm as php-base

RUN apt-get update && apt-get install -y \
    libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Etapa 2: Build de assets
FROM node:18 as node-build

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build

# Etapa 3: Contenedor final con PHP-FPM
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=php-base /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY --from=php-base /var/www/html /var/www/html
COPY --from=node-build /app/public/build /var/www/html/public/build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
