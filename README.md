# BivaCars - Modül 3 UI

Bu commit ile public, partner ve admin tarafında Modül 3 için temel Blade tabanlı ekranlar eklendi.

## Eklenen View Dosyaları
- `resources/views/layouts/app.blade.php`
- `resources/views/components/floating-contact.blade.php`
- `resources/views/public/home.blade.php`
- `resources/views/public/corporate-rental.blade.php`
- `resources/views/partner/vehicles/create.blade.php`
- `resources/views/partner/vehicles/index.blade.php`
- `resources/views/partner/vehicles/price-request.blade.php`
- `resources/views/admin/vehicle-approvals.blade.php`
- `resources/views/admin/price-requests.blade.php`

## Güncellenen Route Listesi (web)
- `/`
- `/kurumsal-kiralama`
- `/partner/araclar`
- `/partner/araclar/yeni`
- `/partner/araclar/{id}/fiyat`
- `/admin/ilan-onaylari`
- `/admin/fiyat-talepleri`

## Basit Manuel Browser Test Adımları
1. Uygulamayı ayağa kaldırın (`php artisan serve`).
2. Ana sayfaya girin:
   - Fırsat Araçlar kartları `/api/public/vehicles/featured` üzerinden yükleniyor mu kontrol edin.
3. `/kurumsal-kiralama`:
   - Model kartları görünüyor mu?
   - 10k/20k/30k paketleri görünüyor mu?
   - Model + paket seçince fiyat özeti güncelleniyor mu?
   - WhatsApp butonu doğru metin ile açılıyor mu?
4. `/partner/araclar/yeni`:
   - 3 adım geçişleri çalışıyor mu?
   - Fiyat alanında net kazanç preview güncelleniyor mu?
   - Kaydet sonrası `/api/partner/vehicles` çağrısı atılıyor mu?
5. `/partner/araclar`:
   - Tabloda durum badge/fiyat/net/featured ve işlem butonları görünüyor mu?
6. `/partner/araclar/{id}/fiyat`:
   - Talep formu gönderiminde `/api/partner/price-change-requests` çağrısı yapılıyor mu?
7. `/admin/ilan-onaylari`:
   - Bekleyen ilanlar listeleniyor mu?
   - Approve/Reject çağrıları ilgili admin endpointlerine gidiyor mu?
8. `/admin/fiyat-talepleri`:
   - Pending talepler listeleniyor mu?
   - Approve/Reject çağrıları çalışıyor mu?
9. Tüm sayfalarda sağ altta floating WhatsApp/Telefon butonlarını doğrulayın.
