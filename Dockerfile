# syntax=docker/dockerfile:1

# ============================================================
#  Aşama 1 — Frontend varlıklarını derle (Vite + Tailwind)
# ============================================================
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* vite.config.js ./
RUN npm ci
COPY resources ./resources
COPY public ./public
RUN npm run build

# ============================================================
#  Aşama 2 — Üretim çalışma ortamı (PHP-FPM + Nginx)
# ============================================================
FROM php:8.2-fpm AS app

# Sistem bağımlılıkları + Nginx + Supervisor
RUN apt-get update && apt-get install -y --no-install-recommends \
        nginx supervisor \
        libpng-dev libjpeg-dev libfreetype6-dev \
        libzip-dev libonig-dev libicu-dev \
        unzip git curl \
    && rm -rf /var/lib/apt/lists/*

# PHP eklentileri (mlocati installer ile güvenilir kurulum)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mysqli gd zip intl bcmath exif opcache pcntl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

# Önce bağımlılık tanımları (katman önbelleği için)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

# Uygulama kaynak kodu
COPY . .

# Derlenmiş frontend varlıkları
COPY --from=assets /app/public/build ./public/build

# Autoloader + paket keşfi
RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# PHP üretim ayarları
RUN { \
        echo "opcache.enable=1"; \
        echo "opcache.enable_cli=0"; \
        echo "opcache.memory_consumption=128"; \
        echo "opcache.max_accelerated_files=10000"; \
        echo "opcache.validate_timestamps=0"; \
        echo "upload_max_filesize=32M"; \
        echo "post_max_size=32M"; \
        echo "memory_limit=256M"; \
    } > /usr/local/etc/php/conf.d/zz-app.ini

# Nginx + Supervisor + Entrypoint
COPY docker/nginx/default.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && sed -i 's/^user .*/user www-data;/' /etc/nginx/nginx.conf

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
