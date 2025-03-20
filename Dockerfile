FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo_mysql pdo_pgsql exif

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar los archivos composer.json y composer.lock
COPY composer.json composer.lock /var/www/html/

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de Composer
RUN composer install

# Copiar el resto del contenido de la aplicación al contenedor
COPY . /var/www/html

# Dar permisos de ejecución al archivo artisan
RUN chmod +x artisan

# Exponer el puerto 8000 (puerto predeterminado de `php artisan serve`)
EXPOSE 8000

# Comando para iniciar el servidor de desarrollo de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
