<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('public.contact', [
            'phone' => config('bivacars.company.phone'),
            'email' => config('bivacars.company.email'),
            'address' => config('bivacars.company.address'),
            'maps_url' => config('bivacars.company.maps_url'),
            'maps_embed_html' => config('bivacars.company.maps_embed_html'),
        ]);
    }
}
