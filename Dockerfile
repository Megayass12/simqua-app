# Menggunakan image PHP dengan FPM
FROM php:8.1-fpm

# Instal dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Instalasi Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja di kontainer
WORKDIR /var/www/html

# Salin semua file proyek ke dalam kontainer
COPY . .

# Atur permission untuk file Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port yang digunakan Laravel
EXPOSE 8000

# Jalankan Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000
