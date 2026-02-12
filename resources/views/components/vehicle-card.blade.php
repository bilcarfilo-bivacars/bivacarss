<article class="rounded-lg border p-4 shadow-sm">
    <img
        src="{{ $vehicle['image'] }}"
        alt="{{ $vehicle['brand'] }} {{ $vehicle['model'] }}"
        width="640"
        height="360"
        loading="lazy"
        decoding="async"
        class="h-auto w-full rounded-md object-cover"
    >
    <h3 class="mt-3 text-lg font-semibold">{{ $vehicle['brand'] }} {{ $vehicle['model'] }}</h3>
</article>
