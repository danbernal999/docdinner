FROM php:8.2-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar código y dependencias
COPY . /app
RUN composer install --ignore-platform-reqs

# Exponer el puerto que Railway asigna
EXPOSE 8080

# Usar el servidor embebido de PHP con tu router
CMD ["php", "-S", "0.0.0.0:8080", "-t", ".", "router.php"]
