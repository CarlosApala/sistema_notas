#!/bin/bash

# Instalar dependencias PHP sin paquetes de desarrollo y optimizar autoloader
composer install --no-dev --optimize-autoloader

# Limpiar cachés para evitar problemas
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Volver a cachear configuraciones, rutas y vistas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Instalar dependencias JS y compilar assets si usas npm/yarn
if [ -f package.json ]; then
    npm install
    npm run production
fi

php artisan key:generate


# Ejecutar migraciones forzadas sin interacción (en producción)
php artisan migrate --force

# (Opcional) Ejecutar seeders si quieres precargar datos
# php artisan db:seed --force

# (Opcional) Dar permisos a storage y bootstrap/cache si es necesario
# chmod -R 775 storage bootstrap/cache
