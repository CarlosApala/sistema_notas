FROM php:8.1-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unixodbc unixodbc-dev libaio-dev wget curl git unzip gnupg \
    && docker-php-ext-install pdo pdo_mysql

# Instalar PDO ODBC
RUN pecl install pdo_odbc \
    && docker-php-ext-enable pdo_odbc

# Descargar e instalar los drivers de Informix
WORKDIR /opt
RUN wget https://github.com/ibmdb/php-informix/releases/download/1.3.4/PDO_INFORMIX-1.3.4.tgz \
    && tar -xvzf PDO_INFORMIX-1.3.4.tgz \
    && cd PDO_INFORMIX-1.3.4 \
    && phpize \
    && ./configure --with-pdo-informix=/opt/IBM/informix \
    && make && make install \
    && docker-php-ext-enable pdo_informix

# Copiar configuración de Apache y PHP (opcional si tienes tu php.ini)
COPY ./php.ini /usr/local/etc/php/

# Configurar el VirtualHost en Apache
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]
