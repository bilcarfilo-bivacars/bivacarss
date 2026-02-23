<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityIndustry;
use App\Models\CorporateModel;
use App\Models\Industry;
use App\Models\KmPackage;
use App\Models\SeoPage;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CityIndustryLandingController extends Controller
{
    public function show(string $citySlug, string $industrySlug): View
    {
        $city = City::query()->where('slug', $citySlug)->firstOrFail();
        $industry = Industry::query()->where('key', $industrySlug)->where('active', true)->firstOrFail();

        $cityIndustry = CityIndustry::query()
            ->where('city_id', $city->id)
            ->where('industry_id', $industry->id)
            ->where('active', true)
            ->firstOrFail();

        $landingData = Cache::remember("bivacars:city_industry:{$cityIndustry->id}", now()->addHour(), function () use ($cityIndustry) {
            return [
                'seo' => SeoPage::query()->where('page_type', 'city_industry')->where('ref_id', $cityIndustry->id)->first(),
            ];
        });

        $pricingData = Cache::remember('bivacars:corporate_pricing', now()->addHour(), fn () => [
            'models' => CorporateModel::query()->orderBy('brand')->get(),
            'packages' => KmPackage::query()->where('is_active', true)->orderBy('km_limit')->get(['id', 'km_limit', 'yearly_price']),
        ]);

        $whatsAppMessage = sprintf(
            'Merhaba, %s bölgesinde %s için kurumsal filo kiralama teklifi istiyorum.',
            $city->name,
            $industry->name
        );

        return view('public.city-industry.show', [
            'city' => $city,
            'industry' => $industry,
            'cityIndustry' => $cityIndustry,
            'seoPage' => $landingData['seo'],
            'models' => $pricingData['models'],
            'packages' => $pricingData['packages'],
            'whatsAppMessage' => $whatsAppMessage,
        ]);
    }
}
