# BivaCars Platform (Laravel + Blade + Tailwind)

Bu repo, BivaCars için **Laravel iskeleti + auth modülü** içerir.

## Özellikler

- Laravel 11 iskelet yapısı (composer bağımlılıkları tanımlı)
- Blade + Tailwind + Vite entegrasyonu
- Session tabanlı panel girişleri:
  - `/admin/login` → `/admin`
  - `/partner/login` → `/partner`
- Sanctum kurulumuna uygun API auth uçları:
  - `POST /api/auth/login`
  - `POST /api/auth/logout`
  - `GET /api/auth/me`
- Kullanıcı şeması:
  - `name`, `phone` (unique), `email` (nullable unique), `password`
  - `role`: `admin|partner`
  - `status`: `active|passive`
- Middleware:
  - `status.active`
  - `admin.only`
  - `partner.only`
- Seeder:
  - `admin@bivacars.com`
  - `Admin12345!`
  - `phone=5550000000`

## Kurulum

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run dev
php artisan serve
```

## Çalıştırma

Web: `http://127.0.0.1:8000`

- Admin login: `http://127.0.0.1:8000/admin/login`
- Partner login: `http://127.0.0.1:8000/partner/login`

## Test adımları

### Admin login

1. `/admin/login` sayfasını açın.
2. Telefon: `5550000000`
3. Şifre: `Admin12345!`
4. Başarılı login sonrası `/admin` açılır.

### Partner login

1. Partner rolünde bir kullanıcı seed/factory ile oluşturun.
2. `/partner/login` üzerinden giriş yapın.
3. Başarılı login sonrası `/partner` açılır.

### API test (JSON)

```bash
curl -i -c cookie.txt -X POST http://127.0.0.1:8000/api/auth/login \
  -H 'Accept: application/json' \
  -d 'phone=5550000000&password=Admin12345!'

curl -i -b cookie.txt http://127.0.0.1:8000/api/auth/me -H 'Accept: application/json'

curl -i -b cookie.txt -X POST http://127.0.0.1:8000/api/auth/logout -H 'Accept: application/json'
```

## Admin Dashboard KPI / Cache

- Admin dashboard KPI metrikleri cache üzerinden servis edilir ve varsayılan TTL ile yük azaltılır.
- Cache key prefix standardı: `bivacars:dashboard:*`
  - `bivacars:dashboard:metrics` (5 dk)
  - `bivacars:dashboard:recent:corporate_leads` (2 dk)
  - `bivacars:dashboard:recent:partner_leads` (2 dk)
  - `bivacars:dashboard:recent:leases` (2 dk)
- KPI örnekleri:
  - Bugünkü partner ve corporate lead adetleri
  - Son 30 gündeki high value lead adedi
  - Aktif/öne çıkan araç adetleri
  - Bekleyen fiyat talebi ve bekleyen ödeme sayıları
  - Aktif lease aylık toplam bedeline göre aylık gelir tahmini
