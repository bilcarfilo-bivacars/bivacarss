<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\LocationPoint;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $xml = Cache::remember('sitemap.xml', 86400, function () {
            $urls = [url('/'), url('/hizmet-bolgeleri')];

            $cities = City::query()->where('active', true)->get();
            foreach ($cities as $city) {
                $urls[] = url('/hizmet-bolgeleri/' . $city->slug);
            }

            $districts = District::query()->where('active', true)->with('city')->get();
            foreach ($districts as $district) {
                if ($district->city) {
                    $urls[] = url('/hizmet-bolgeleri/' . $district->city->slug . '/' . $district->slug);
                }
            }

            $points = LocationPoint::query()->where('active', true)->with(['city', 'district'])->get();
            foreach ($points as $point) {
                if ($point->city && $point->district) {
                    $urls[] = url('/hizmet-bolgeleri/' . $point->city->slug . '/' . $point->district->slug . '/' . $point->slug);
                }
            }

            $items = collect(array_unique($urls))->map(function ($url) {
                return "<url><loc>{$url}</loc><changefreq>weekly</changefreq></url>";
            })->implode('');

            return '<?xml version="1.0" encoding="UTF-8"?>'
                . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
                . $items
                . '</urlset>';
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
