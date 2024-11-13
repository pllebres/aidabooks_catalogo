# Usa una imagen base de PHP con Composer
FROM php:8.2-fpm

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de la aplicación al contenedor
COPY . .

# Instala las dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Copia el archivo de entorno y genera la clave de aplicación
COPY .env.example .env
RUN php artisan key:generate

# Da permisos al almacenamiento y caché
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expone el puerto 8000
EXPOSE 8000

# Comando para iniciar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
