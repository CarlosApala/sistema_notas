FROM php:8.1-fpm as php-base

RUN apt-get update && apt-get install -y libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader

COPY . .

# Stage node-build para assets
FROM node:18 as node-build

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install

# Copiar el proyecto completo *incluyendo* vendor generado en stage anterior
COPY --from=php-base /app/vendor ./vendor
COPY . .

RUN npm run build

# Luego stage final PHP

FROM php:8.1-fpm

# ...instalaciones y configuraciones...

WORKDIR /var/www/html

COPY --from=php-base /app /var/www/html
COPY --from=node-build /app/public/build /var/www/html/public/build

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
