FROM php:8.2-cli

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    zip unzip git libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html


# Copiar los archivos del proyecto
COPY . .

# Instalar dependencias de Composer
RUN composer install --no-interaction --optimize-autoloader

# Establecer comando por defecto
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
