FROM php:8.3-apache

# Instala extensiones PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia los archivos al contenedor
COPY . /var/www/html/

# Habilita mod_rewrite
RUN a2enmod rewrite

# Fix del warning de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Reemplaza la configuración de Apache para escuchar en 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:8080>/' /etc/apache2/sites-available/000-default.conf

# Exponer puerto
EXPOSE 8080

# Arrancar Apache
CMD ["apache2-foreground"]
