<?php

use Illuminate\Support\Facades\Route;

Route::get('/iletisim', function () {
    return view('public.contact', [
        'phoneDisplay' => config('bivacars.phone_display'),
        'email' => config('bivacars.email'),
        'address' => config('bivacars.address'),
        'mapsUrl' => config('bivacars.maps_url'),
    ]);
});
