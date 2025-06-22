# Etapa 1: PHP base con dependencias y vendor
FROM php:8.1-fpm as php-base

RUN apt-get update && apt-get install -y libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar TODO el código fuente primero (incluyendo artisan, app/, etc.)
COPY . .

# Instalar dependencias PHP (ya existe artisan y service providers)
RUN composer install --no-dev --optimize-autoloader

# Etapa 2: Construcción de assets con Node
FROM node:18 as node-build

WORKDIR /app

# Copiar package files primero
COPY package.json package-lock.json ./

RUN npm install

# Copiar el proyecto completo desde php-base, que ya contiene vendor/
COPY --from=php-base /app .

# Ejecutar build (esto genera public/build)
RUN npm run build

# Etapa final: PHP + Laravel listo para producción
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y libpq-dev unzip zip git curl \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el código completo desde php-base
COPY --from=php-base /app /var/www/html

# Copiar los assets compilados de node-build
COPY --from=node-build /app/public/build /var/www/html/public/build

# No se copia .env aquí: Render lo inyecta desde la UI

# Cachear configuraciones (siempre después de tener .env en entorno)
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
