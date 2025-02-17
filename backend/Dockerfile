<<<<<<< HEAD
# Usa la imagen oficial de PHP
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

COPY ./ /var/www/html

# Instala Composer para gestionar dependencias
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Exponer el puerto 8000 para acceder a la aplicación
EXPOSE 8000

# Comando para ejecutar el servidor PHP integrado
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
=======
# Usar una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    libzip-dev \
    && docker-php-ext-install zip mysqli pdo pdo_mysql

# Instalar Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Copiar archivos al contenedor
COPY . /var/www/html/

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Ir al directorio de trabajo
WORKDIR /var/www/html/

# Configurar autenticación en Composer (opcional, si usas paquetes privados)
RUN composer config --global --auth

# Instalar dependencias de Composer
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress || cat /var/www/html/composer.lock

# Exponer el puerto 80
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
>>>>>>> dev
