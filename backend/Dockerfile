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
