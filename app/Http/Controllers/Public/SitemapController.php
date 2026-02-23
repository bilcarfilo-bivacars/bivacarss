<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CityIndustry;
use App\Models\Industry;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('bivacars:sitemap.xml', now()->addDay(), function () {
            $urls = [url('/'), url('/sektorler')];

            $industryUrls = Industry::query()->where('active', true)->pluck('key')->map(fn ($key) => url('/sektorler/'.$key))->all();

            $comboUrls = CityIndustry::query()
                ->with(['city:id,slug', 'industry:id,key'])
                ->where('active', true)
                ->get()
                ->map(fn ($pivot) => url('/filo-kiralama/'.$pivot->city->slug.'/'.$pivot->industry->key))
                ->all();

            $all = array_merge($urls, $industryUrls, $comboUrls);

            $items = collect($all)->map(fn ($url) => '<url><loc>'.$url.'</loc></url>')->implode('');

            return '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$items.'</urlset>';
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
