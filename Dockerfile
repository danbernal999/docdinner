FROM php:8.3-apache

# Instala extensiones
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia proyecto
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Fix warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Cambiar configuración para escuchar en 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/' /etc/apache2/sites-available/000-default.conf

# Revisar DocumentRoot explícitamente
RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html#' /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["apache2-foreground"]
