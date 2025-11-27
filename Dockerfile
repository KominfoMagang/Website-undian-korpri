############################################################################################
# 2) PHP STAGE — Main Production / App Container
############################################################################################
FROM php:8.3-fpm AS php_app

# ===================================================================
# 1. Set working directory aplikasi (semua perintah setelah ini
#    akan dieksekusi di /var/www, jadi hidup lebih teratur)
# ===================================================================
WORKDIR /var/www

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

# ===================================================================
# 3. Install ekstensi-ekstensi PHP:
#    - zip        : untuk kompresi (composer, export, dll)
#    - pdo_mysql  : koneksi ke MySQL/MariaDB
#    - mbstring   : string multibyte (UTF-8 friendly)
#    - exif       : meta foto (kalau butuh)
#    - pcntl      : proses control (queue, dsb)
#    - bcmath     : operasi angka besar / presisi tinggi
#    - gd         : manipulasi gambar
#      -> Kunci penting: gd di-konfigurasi dengan FreeType & JPEG
#         supaya fungsi imagettfbbox(), imagettftext(), dll AKTIF.
# ===================================================================
RUN docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd

# ===================================================================
# 4. Copy Composer dari image resmi, biar gak perlu install manual
# ===================================================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ===================================================================
# 5. Copy source code Laravel ke dalam container
#    (pastikan .env sudah ada di server atau di-mount via volume)
# ===================================================================
COPY . /var/www

# ===================================================================
# 6. Install dependency Composer MODE PRODUKSI:
#    - --no-dev              : package dev dibuang
#    - --optimize-autoloader : autoloader lebih cepat
#    - --no-interaction      : biar build jalan otomatis
# ===================================================================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ===================================================================
# 7. Set permission folder penting Laravel:
#    - storage dan bootstrap/cache harus bisa ditulis web server
# ===================================================================
RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache

EXPOSE 9000

CMD ["sh", "-c", "php artisan migrate:fresh --force && php-fpm"]
