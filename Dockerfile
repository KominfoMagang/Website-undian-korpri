##############################################
# 1) NODE STAGE — Build Vite Assets
##############################################
FROM node:18 AS node_build

WORKDIR /app

# Only copy package files first (better caching)
COPY package*.json ./
RUN npm ci

# Copy full source code
COPY . .

# Build Vite assets
RUN npm run build



##############################################
# 2) PHP STAGE — Main Production Container
##############################################
FROM php:8.3-fpm AS php_app

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip unzip git curl \
    libonig-dev \
    libxml2-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    vim \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd



##############################################
# Install Composer from official image
##############################################
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer



##############################################
# Copy source code
##############################################
COPY . /var/www

# Copy Vite build results from node stage
COPY --from=node_build /app/public/build ./public/build
COPY --from=node_build /app/public/manifest.json ./public/manifest.json



##############################################
# Composer install (Production)
##############################################
RUN composer install --no-dev --optimize-autoloader --no-interaction



##############################################
# Set correct permissions
##############################################
RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache



##############################################
# FPM
##############################################
EXPOSE 9000
CMD ["php-fpm"]
