#!/bin/bash

# Instalar dependencias PHP sin paquetes de desarrollo y optimizar autoloader
composer install --no-dev --optimize-autoloader

# Limpiar cachés para evitar problemas
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear


# Compilar assets con Vite
if [ -f package.json ]; then
    npm install
    npm run build
fi

# Generar la APP_KEY
php artisan key:generate

# Cachear configuraciones, rutas y vistas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones forzadas sin interacción
php artisan migrate --force
