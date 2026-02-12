@php
    $phoneE164 = config('bivacars.phone_e164');
    $phoneDisplay = config('bivacars.phone_display');
    $whatsappE164 = ltrim(config('bivacars.whatsapp_e164'), '+');
@endphp

<div class="floating-contact">
    <a href="tel:{{ $phoneE164 }}">Ara: {{ $phoneDisplay }}</a>
    <a href="https://wa.me/{{ $whatsappE164 }}" target="_blank" rel="noopener noreferrer">WhatsApp</a>
</div>
