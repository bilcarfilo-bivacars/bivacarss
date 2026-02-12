# WhatsApp Chatbot (Webhook + Admin Yönetimi)

## Genel Mimari
Bu modül provider bağımsız bir yapı ile tasarlanmıştır.
- `ChatbotProviderInterface`: gönderim sözleşmesi
- `WhatsAppCloudProvider`: Meta WhatsApp Cloud API implementasyonu
- `ChatbotReplyResolver`: flow + trigger eşleştirme mantığı

## Gerekli ENV Değerleri
```env
WHATSAPP_VERIFY_TOKEN=
WHATSAPP_TOKEN=
WHATSAPP_PHONE_NUMBER_ID=
WHATSAPP_API_VERSION=v19.0
BIVACARS_MAPS_URL=
```

> Güvenlik için gerçek token/secret değerlerini kesinlikle repoya koymayın.

## Meta Cloud API Kurulum Özeti
1. Meta for Developers üzerinde WhatsApp Cloud uygulaması açın.
2. Geçici veya kalıcı access token alın.
3. Phone Number ID bilgisini alın.
4. Uygulamanızın webhook URL'sini girin: `https://domaininiz.com/webhooks/whatsapp`
5. Verify token olarak `.env` içindeki `WHATSAPP_VERIFY_TOKEN` değerini kullanın.
6. Mesaj event'lerini subscribe edin.

## Webhook Verify
- Endpoint: `GET /webhooks/whatsapp`
- Parametreler: `hub.mode`, `hub.verify_token`, `hub.challenge`
- Doğru verify token ise challenge değeri 200 ile döner.

## Mesaj İşleme
- Endpoint: `POST /webhooks/whatsapp`
- Rate limit: `60/dakika/ip`
- Gelen payload `chatbot_logs` tablosuna yazılır.
- Metin normalize edilip (`trim + lowercase`) main menu flow üzerinde eşleşme yapılır:
  1. exact trigger (`1`, `2`, `5`, `menu` vb)
  2. contains trigger (`merhaba`, `selam`, `start`)
  3. fallback: `Menü için 1-6 yazın` + ana menü mesajı

## Geliştirme Modu
Eğer `WHATSAPP_TOKEN` veya `WHATSAPP_PHONE_NUMBER_ID` yoksa provider gerçek API çağrısı atmaz; sadece log yazar ve 200 döner.

## Admin Panel
- `GET /admin/chatbot`: Flow listeleme + aktif/pasif toggle
- `GET /admin/chatbot/{flow}/mesajlar`: mesaj listeleme/düzenleme
- `POST /admin/chatbot/{flow}/mesajlar`: mesaj ekleme
- `PATCH /admin/chatbot/{flow}/mesajlar/{message}`: mesaj güncelleme

Admin ekranları `auth` + `admin.only` middleware ile korunur.

## Test / Local Deneme
1. `php artisan migrate --seed`
2. `php artisan serve`
3. Dış erişim için ngrok kullanın:
   ```bash
   ngrok http 8000
   ```
4. Meta webhook URL'sine ngrok adresini verin.
5. Manuel test için webhook POST payload gönderin.
