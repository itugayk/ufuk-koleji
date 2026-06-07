# Ufuk Koleji — Kurumsal Okul Web Sitesi & Yönetim Paneli

Anaokulundan liseye eğitim veren bir özel okul için geliştirilmiş, **kurumsal tanıtım sitesi + haber/duyuru CMS + çok adımlı kayıt başvuru sistemi + tam donanımlı yönetim paneli**.

> Premium portfolyo demosu · `okul.demo.dijifa.com`

## ✨ Özellikler

### Public site
- **Modern, kurumsal tasarım** — lacivert (#13315c) + altın (#f5b301) palet, Poppins/Sora başlık + Inter gövde tipografisi
- **Ana sayfa** — hero, kademeler, eğitim modeli, animasyonlu başarı sayaçları, haberler, kampüs galerisi, veli yorumları, başvuru CTA
- **Kademeler** — Anaokulu / İlkokul / Ortaokul / Lise detay sayfaları
- **Kurumsal** — vizyon, misyon, tarihçe (admin'den düzenlenebilir)
- **Eğitim Modeli**, **Kampüs Galerisi** (kategori filtreli), **Başarılarımız**
- **Haberler & Duyurular** — Livewire ile canlı arama, kategori/tür filtresi, sayfalama; detay sayfası + ilgili içerikler
- **Kayıt Başvurusu** — 4 adımlı Livewire sihirbazı (kademe → öğrenci → veli → onay)
- **İletişim** — form (DB'ye kayıt) + harita + iletişim bilgileri
- **SEO** — `School` / `EducationalOrganization` JSON-LD, Open Graph, dinamik meta etiketleri
- WhatsApp hızlı erişim butonu, kırık görselleri engelleyen güvenli görsel bileşeni

### Yönetim Paneli (`/admin` · Filament 3)
- **Haber/Duyuru CRUD** — Spatie Media görsel yükleme, kategori, etiket, yayın tarihi, öne çıkarma
- **Kademe & Sayfa içerikleri** yönetimi
- **Kayıt başvuruları** — durum takibi (Yeni / Görüşüldü / Beklemede / Kabul / Red), yeni başvuru rozeti
- **Galeri, Başarılar, Veli Yorumları, Etkinlikler, İletişim mesajları** yönetimi
- **Site Ayarları** sayfası (iletişim, sosyal medya, hero metinleri)
- **Dashboard** — istatistik widget'ları + son başvurular tablosu

## 🛠 Teknoloji

| Katman | Teknoloji |
|--------|-----------|
| Backend | Laravel 12, PHP 8.2 |
| Admin | Filament 3 |
| Etkileşim | Livewire 3 + Alpine.js |
| Stil | Tailwind CSS v4 (Vite) |
| Görsel | Spatie Media Library |
| Veritabanı | MySQL 8 (yerel geliştirmede SQLite) |
| Dağıtım | Docker + Docker Compose, Coolify |

## 🚀 Yerel Kurulum

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed   # demo içeriği yükler
npm run build
php artisan serve
```

Site: `http://localhost:8000` · Panel: `http://localhost:8000/admin`

**Demo yönetici girişi:** `admin@ufukkoleji.com` / `password`

## 🐳 Docker ile Çalıştırma

```bash
docker compose up -d --build
```

- Uygulama: `http://localhost:8080`
- MySQL otomatik kurulur, migration + seed otomatik çalışır.

## ☁️ Coolify ile Dağıtım

1. Bu repoyu Coolify'da yeni bir uygulama olarak bağlayın (**Build Pack: Dockerfile**).
2. Coolify'da bir **MySQL** veritabanı oluşturun.
3. Aşağıdaki ortam değişkenlerini tanımlayın (bkz. `.env.production`):
   `APP_KEY`, `APP_URL=https://okul.demo.dijifa.com`, `DB_*`, `SESSION_DRIVER=database`, `CACHE_STORE=database`.
4. Domain olarak `okul.demo.dijifa.com` atayın ve **Deploy** edin.

Konteyner başlangıcında migration çalışır, veritabanı boşsa demo içeriği otomatik yüklenir.

---

© Dijifa · Demo amaçlı geliştirilmiştir.
