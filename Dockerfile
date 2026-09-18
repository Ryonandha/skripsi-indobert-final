# SiPeka Web (Laravel) — image untuk Azure Container Apps
# Build dari dalam folder "web":
#   docker build -t sipeka-web:v1 .
#
# Konsisten dengan pola deploy model (lihat deploy/CARA-DEPLOY-AZURE.md di
# root proyek): build image di luar Azure (lokal / GitHub Actions), baru push
# ke ACR — karena `az acr build` (ACR Tasks) diblokir di langganan
# Azure for Students.

# ---- Stage 1: build asset frontend (Vite) ----
FROM node:20-slim AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

# ---- Stage 2: install dependensi PHP (composer, tanpa dev) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
COPY . .
RUN composer dump-autoload --optimize --no-dev

# ---- Stage 3: runtime image (PHP + Apache) ----
FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev unzip libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
        libicu-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring bcmath exif gd intl zip opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Opcache produksi (percepat eksekusi PHP)
RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.max_accelerated_files=10000'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

WORKDIR /var/www/html

# Arahkan DocumentRoot Apache ke public/ (root Laravel) + izinkan .htaccess
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# Azure Container Apps: samakan port dengan --target-port saat containerapp create
ENV APACHE_PORT=8080
RUN sed -i "s/80/${APACHE_PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 8080

COPY --from=vendor /app ./
COPY --from=assets /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]
