FROM php:8.3-apache

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar proyecto
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Fix del warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Script de arranque para reemplazar el puerto en runtime
CMD sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
    && sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf \
    && apache2-foreground
