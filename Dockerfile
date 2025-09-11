# Imagen base con PHP y Apache
FROM php:8.3-apache

# Instala extensiones necesarias (puedes añadir más si tu proyecto las requiere)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html/

# Habilita mod_rewrite (por si usas URLs limpias o .htaccess)
RUN a2enmod rewrite

# Cambia la configuración de Apache para escuchar en el puerto 8080 (el que Railway expone)
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/80/8080/g' /etc/apache2/ports.conf

# Exponer puerto
EXPOSE 8080

# Inicia Apache en primer plano
CMD ["apache2-foreground"]
