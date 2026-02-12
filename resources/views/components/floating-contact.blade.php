@php
    $waNumber = config('bivacars.whatsapp_number');
    $phoneNumber = config('bivacars.phone_number');
    $waMessage = rawurlencode('Merhaba, BivaCars üzerinden bilgi almak istiyorum.');
@endphp

<div style="position:fixed;right:16px;bottom:16px;display:flex;flex-direction:column;gap:10px;z-index:999;">
    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" style="background:#25D366;color:#fff;padding:12px 14px;border-radius:999px;text-decoration:none;font-weight:600;box-shadow:0 8px 25px rgba(0,0,0,.2);">WhatsApp</a>
    <a href="tel:{{ $phoneNumber }}" style="background:#0a66c2;color:#fff;padding:12px 14px;border-radius:999px;text-decoration:none;font-weight:600;box-shadow:0 8px 25px rgba(0,0,0,.2);">Telefon</a>
</div>
