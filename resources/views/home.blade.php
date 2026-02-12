<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BivaCars</title>
    <script defer>
        async function loadFeaturedVehicles() {
            const response = await fetch('/api/public/vehicles/featured');
            const data = await response.json();
            const container = document.getElementById('featured-list');

            if (!Array.isArray(data) || data.length === 0) {
                container.innerHTML = '<p class="text-sm text-gray-500">Henüz öne çıkan araç yok.</p>';
                return;
            }

            container.innerHTML = data.map(vehicle => `
                <div class="rounded border p-3">
                    <h3 class="font-semibold">${vehicle.brand} ${vehicle.model}</h3>
                    <p class="text-sm text-gray-600">Aylık: ${vehicle.listing_price_monthly ?? '-'} ₺</p>
                </div>
            `).join('');
        }

        async function initPopup() {
            const cookieKey = 'bivacars_popup_seen_at';
            const now = Date.now();
            const seenAt = Number(localStorage.getItem(cookieKey) || 0);

            const response = await fetch('/popup-settings');
            const settings = await response.json();
            const threshold = (settings.repeat_hours || 24) * 60 * 60 * 1000;

            if (!settings.enabled || (seenAt > 0 && now - seenAt < threshold)) {
                return;
            }

            const popup = document.getElementById('popup');
            popup.querySelector('[data-popup-text]').textContent = settings.text;
            popup.classList.remove('hidden');

            popup.querySelector('[data-popup-close]').addEventListener('click', () => {
                popup.classList.add('hidden');
                localStorage.setItem(cookieKey, String(Date.now()));
            });
        }

        document.addEventListener('DOMContentLoaded', async () => {
            await loadFeaturedVehicles();
            await initPopup();
        });
    </script>
</head>
<body class="bg-gray-50 text-gray-900">
<div class="mx-auto max-w-4xl px-4 py-10">
    <h1 class="mb-6 text-2xl font-bold">BivaCars</h1>

    <section>
        <h2 class="mb-3 text-xl font-semibold">Fırsat Araçlar</h2>
        <div id="featured-list" class="grid grid-cols-1 gap-3 md:grid-cols-3">
            <p class="text-sm text-gray-500">Yükleniyor...</p>
        </div>
    </section>
</div>

<x-popup />
</body>
</html>
