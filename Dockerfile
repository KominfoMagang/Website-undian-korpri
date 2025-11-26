##############################################
# 1) NODE STAGE — Build Vite Assets
##############################################
FROM node:18 AS node_build
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


##############################################
# 2) PHP STAGE — Production
##############################################
FROM php:8.3-fpm AS php_app
WORKDIR /var/www

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev zip unzip git curl libonig-dev libxml2-dev \
    && docker-php-ext-install zip pdo_mysql mbstring bcmath exif gd

# Copy source code (NO BUILD YET)
COPY . .

# Copy Vite assets (overwrite)
COPY --from=node_build /app/public/build ./public/build

# Install Composer deps
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
