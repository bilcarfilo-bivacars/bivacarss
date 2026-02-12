# BivaCars - Modül 7 (Kurumsal Teklif PDF + WhatsApp Share)

## Kurulum Notları

- Public PDF erişimi için sembolik link oluşturun:

```bash
php artisan storage:link
```

- PDF şablonu konumu:

`resources/views/pdf/corporate-offer.blade.php`

- PDF üretim servisi:

`app/Services/Pdf/CorporateOfferPdfService.php`

- Kullanılan paket (önerilen):

`barryvdh/laravel-dompdf`
