FROM php:8.3-apache

# Instala extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia archivos
COPY . /var/www/html/

# Habilita mod_rewrite
RUN a2enmod rewrite

# Fix warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Usar la variable $PORT de Railway (si no existe, por defecto 8080)
ENV PORT=8080
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf \
    && sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Exponer el puerto dinámico
EXPOSE ${PORT}

CMD ["apache2-foreground"]
