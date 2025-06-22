# Etapa 1: PHP base con dependencias y vendor
FROM php:8.1-fpm as php-base

RUN apt-get update && apt-get install -y libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar solo composer para cachear dependencias
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader

# Copiar todo el código (sin node_modules ni vendor)
COPY . .

# Etapa 2: Construcción de assets con Node
FROM node:18 as node-build

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install

# Copiar el código completo (incluyendo vendor de php-base para imports si se necesitan)
COPY --from=php-base /app .

# Ejecutar build (produce /public/build)
RUN npm run build

# Etapa final: PHP + Laravel listo para producción
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el código y vendor completo desde php-base
COPY --from=php-base /app /var/www/html

# Copiar los assets compilados de node-build (public/build)
COPY --from=node-build /app/public/build /var/www/html/public/build

# NO COPIAR EL .env - usar variables de entorno externas

# Cachear configuraciones para producción (opcional)
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
