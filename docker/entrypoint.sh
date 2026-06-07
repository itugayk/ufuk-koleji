#!/usr/bin/env bash
set -e

cd /var/www/html

echo "→ Ufuk Koleji başlatılıyor..."

# Yazma izinleri
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# Public storage sembolik bağlantısı
php artisan storage:link >/dev/null 2>&1 || true

# Veritabanı hazır olana kadar migrate dene
ATTEMPTS=0
until php artisan migrate --force 2>/dev/null; do
    ATTEMPTS=$((ATTEMPTS + 1))
    if [ "$ATTEMPTS" -ge 15 ]; then
        echo "✗ Veritabanına bağlanılamadı; migrate atlanıyor."
        break
    fi
    echo "… Veritabanı bekleniyor ($ATTEMPTS/15)"
    sleep 3
done

# Veritabanı boşsa demo içeriğini yükle (yalnızca ilk kurulumda)
LEVELS=$(php artisan tinker --execute="echo \App\Models\Level::count();" 2>/dev/null | tail -n1 | tr -dc '0-9')
if [ -z "$LEVELS" ] || [ "$LEVELS" = "0" ]; then
    echo "→ Demo içeriği yükleniyor (seed)..."
    php artisan db:seed --force || true
fi

# Üretim önbellekleri
php artisan config:cache >/dev/null 2>&1 || true
php artisan route:cache >/dev/null 2>&1 || true
php artisan view:cache >/dev/null 2>&1 || true
php artisan filament:cache-components >/dev/null 2>&1 || true

echo "✓ Uygulama hazır."

exec "$@"
