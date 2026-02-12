<?php

use App\Services\PublicDataService;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::view('/', 'welcome');

    Route::post('/admin/login', fn () => response()->noContent())->middleware('throttle:login-attempts');
    Route::post('/partner/login', fn () => response()->noContent())->middleware('throttle:login-attempts');

    Route::get('/hizmet-bolgeleri', function (PublicDataService $service) {
        return response()->json($service->serviceAreas());
    });

    Route::get('/sitemap.xml', function () {
        $xml = Cache::remember(CacheKeys::SITEMAP_XML, now()->addDay(), function () {
            return <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://bivacars.com/</loc>
  </url>
  <url>
    <loc>https://bivacars.com/hizmet-bolgeleri</loc>
  </url>
</urlset>
XML;
        });

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    })->name('sitemap');
});
