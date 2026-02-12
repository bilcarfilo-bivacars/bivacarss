<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceAreasSeeder extends Seeder
{
    public function run(): void
    {
        $districtSeoCount = 0;
        $pointSeoCount = 0;
        $citySeoCount = 0;

        $cities = [
            [
                'name' => 'İstanbul Anadolu Yakası',
                'slug' => 'istanbul-anadolu',
                'districts' => [
                    'Kadıköy',
                    'Üsküdar',
                    'Ataşehir',
                    'Maltepe',
                    'Kartal',
                    'Pendik',
                    'Tuzla',
                    'Sancaktepe',
                    'Sultanbeyli',
                    'Çekmeköy',
                    'Ümraniye',
                    'Beykoz',
                    'Şile',
                ],
                'points' => [
                    ['name' => 'Sabiha Gökçen Havalimanı', 'type' => 'havalimani'],
                    ['name' => 'Kadıköy Otogar', 'type' => 'otogar'],
                    ['name' => 'Söğütlüçeşme Tren Garı', 'type' => 'tren-gari'],
                    ['name' => 'Viaport AVM', 'type' => 'avm'],
                    ['name' => 'Optimum AVM', 'type' => 'avm'],
                ],
            ],
            [
                'name' => 'Kocaeli',
                'slug' => 'kocaeli',
                'districts' => [
                    'Gebze',
                    'Darıca',
                    'İzmit',
                    'Körfez',
                    'Derince',
                    'Gölcük',
                    'Başiskele',
                    'Kartepe',
                    'Karamürsel',
                    'Kandıra',
                    'Dilovası',
                    'Çayırova',
                ],
                'points' => [
                    ['name' => 'Gebze Otogar', 'type' => 'otogar'],
                    ['name' => 'İzmit Otogar', 'type' => 'otogar'],
                    ['name' => 'İzmit Tren Garı', 'type' => 'tren-gari'],
                    ['name' => 'Cengiz Topel Havalimanı', 'type' => 'havalimani'],
                    ['name' => '41 Burda AVM', 'type' => 'avm'],
                ],
            ],
        ];

        foreach ($cities as $cityIndex => $cityData) {
            $cityId = $this->upsertCity($cityData['name'], $cityData['slug']);

            $citySeo = $this->buildCitySeo($cityData['name'], $cityData['slug'], $cityIndex);
            $this->upsertSeoPage('city', $cityId, $citySeo);
            $citySeoCount++;

            foreach ($cityData['districts'] as $districtIndex => $districtName) {
                $districtId = $this->upsertDistrict($cityId, $districtName, Str::slug($districtName));

                $districtSeo = $this->buildDistrictSeo($districtName, $cityData['name'], $districtIndex);
                $this->upsertSeoPage('district', $districtId, $districtSeo);
                $districtSeoCount++;
            }

            foreach ($cityData['points'] as $pointIndex => $pointData) {
                $pointId = $this->upsertPoint(
                    $cityId,
                    $pointData['name'],
                    Str::slug($pointData['name']),
                    $pointData['type']
                );

                $pointSeo = $this->buildPointSeo(
                    $pointData['name'],
                    $pointData['type'],
                    $cityData['name'],
                    $pointIndex
                );
                $this->upsertSeoPage('point', $pointId, $pointSeo);
                $pointSeoCount++;
            }
        }

        $totalSeo = $citySeoCount + $districtSeoCount + $pointSeoCount;

        $this->command?->info('Seedlenen ilçeler: Kadıköy, Üsküdar, Ataşehir, Maltepe, Kartal, Pendik, Tuzla, Sancaktepe, Sultanbeyli, Çekmeköy, Ümraniye, Beykoz, Şile, Gebze, Darıca, İzmit, Körfez, Derince, Gölcük, Başiskele, Kartepe, Karamürsel, Kandıra, Dilovası, Çayırova');
        $this->command?->info("Oluşturulan SEO sayfa adedi: {$totalSeo} (city: {$citySeoCount}, district: {$districtSeoCount}, point: {$pointSeoCount})");
    }

    private function upsertCity(string $name, string $slug): int
    {
        DB::table('cities')->updateOrInsert(
            ['slug' => $slug],
            [
                'name' => $name,
                'slug' => $slug,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return (int) DB::table('cities')->where('slug', $slug)->value('id');
    }

    private function upsertDistrict(int $cityId, string $name, string $slug): int
    {
        DB::table('districts')->updateOrInsert(
            [
                'city_id' => $cityId,
                'slug' => $slug,
            ],
            [
                'name' => $name,
                'slug' => $slug,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return (int) DB::table('districts')
            ->where('city_id', $cityId)
            ->where('slug', $slug)
            ->value('id');
    }

    private function upsertPoint(int $cityId, string $name, string $slug, string $type): int
    {
        DB::table('points')->updateOrInsert(
            [
                'city_id' => $cityId,
                'slug' => $slug,
            ],
            [
                'name' => $name,
                'slug' => $slug,
                'type' => $type,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return (int) DB::table('points')
            ->where('city_id', $cityId)
            ->where('slug', $slug)
            ->value('id');
    }

    private function upsertSeoPage(string $pageType, int $entityId, array $seo): void
    {
        DB::table('seo_pages')->updateOrInsert(
            [
                'page_type' => $pageType,
                'entity_id' => $entityId,
            ],
            [
                'h1' => $seo['h1'],
                'title' => $seo['title'],
                'meta_description' => $seo['meta_description'],
                'content' => $seo['content'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    private function buildCitySeo(string $cityName, string $citySlug, int $variant): array
    {
        $cta = $variant % 2 === 0
            ? 'Hemen WhatsApp üzerinden talep gönderin, size en uygun aracı dakikalar içinde ayıralım.'
            : 'Kısa süreli ya da kurumsal kiralama için WhatsApp hattımızdan hızlı teklif alın.';

        return [
            'h1' => "{$cityName} Araç Kiralama",
            'title' => "{$cityName} Araç Kiralama | BivaCars",
            'meta_description' => "{$cityName} bölgesinde günlük ve kurumsal araç kiralama. WhatsApp ile hızlı rezervasyon.",
            'content' => "{$cityName} içinde şehir içi ve şehirler arası kullanıma uygun araç seçenekleri sunuyoruz. BivaCars ile ihtiyacınıza göre ekonomik, SUV veya geniş aile araçlarına kolayca ulaşabilirsiniz.\n\n"
                . "Teslimat ve iade süreçlerini planınıza göre esnek şekilde yönetebilir, iş veya tatil programınıza uygun rezervasyon yapabilirsiniz. Özellikle {$citySlug} tarafında hızlı geri dönüş ve net fiyatlandırma ile öne çıkıyoruz.\n\n"
                . "Neden BivaCars?\n"
                . "- Günlük ve kurumsal kiralama alternatifleri\n"
                . "- Şeffaf fiyatlandırma ve hızlı onay\n"
                . "- WhatsApp destek hattı ile kolay iletişim\n\n"
                . $cta,
        ];
    }

    private function buildDistrictSeo(string $districtName, string $cityName, int $variant): array
    {
        $introOptions = [
            "{$districtName} bölgesinde araç kiralama ihtiyaçlarınız için BivaCars pratik ve güvenilir çözümler sunar.",
            "BivaCars ile {$districtName} çevresinde kısa ve uzun dönem araç kiralama süreçlerini kolayca yönetebilirsiniz.",
        ];

        $detailOptions = [
            "{$cityName} trafiğine ve yol planına uygun araç seçenekleriyle günlük işlerinizden hafta sonu kaçamaklarına kadar farklı ihtiyaçlara yanıt veriyoruz.",
            "Özellikle {$districtName} çıkışlı seyahatlerde zaman kaybetmeden araç teslimi alabilir, planınıza göre iade yapabilirsiniz.",
        ];

        $ctaOptions = [
            "WhatsApp hattımıza yazın, {$districtName} için en uygun aracı hemen rezerve edelim.",
            "{$districtName} için hızlı teklif almak isterseniz WhatsApp üzerinden anında iletişime geçebilirsiniz.",
        ];

        return [
            'h1' => "{$districtName} Araç Kiralama",
            'title' => "{$districtName} Araç Kiralama | BivaCars",
            'meta_description' => "{$districtName} bölgesinde günlük ve kurumsal araç kiralama. WhatsApp ile hızlı rezervasyon.",
            'content' => $introOptions[$variant % count($introOptions)] . "\n\n"
                . $detailOptions[$variant % count($detailOptions)] . "\n\n"
                . "{$districtName} araç kiralama hizmetinde sunduklarımız:\n"
                . "- Günlük, haftalık ve aylık kiralama planları\n"
                . "- Kurumsal müşterilere özel operasyon desteği\n"
                . "- Hızlı rezervasyon ve net teslim süreci\n\n"
                . $ctaOptions[$variant % count($ctaOptions)],
        ];
    }

    private function buildPointSeo(string $pointName, string $pointType, string $cityName, int $variant): array
    {
        $typeLabels = [
            'otogar' => 'Otogar',
            'tren-gari' => 'Tren Garı',
            'avm' => 'AVM',
            'havalimani' => 'Havalimanı',
        ];

        $focus = $typeLabels[$pointType] ?? 'Nokta';

        $cta = $variant % 2 === 0
            ? "{$pointName} yakınında teslim seçenekleri için WhatsApp üzerinden hemen bize yazın."
            : "{$pointName} civarında hızlı rezervasyon için WhatsApp hattımızdan anında teklif alın.";

        return [
            'h1' => "{$pointName} Yakınında Araç Kiralama",
            'title' => "{$pointName} Yakınında Araç Kiralama | BivaCars",
            'meta_description' => "{$pointName} çevresinde hızlı araç kiralama, kolay teslimat ve WhatsApp ile anında rezervasyon.",
            'content' => "{$cityName} bölgesindeki {$focus} noktalarına yakın araç kiralama ihtiyaçlarınız için BivaCars hızlı çözümler sunar. {$pointName} yakınında size uygun sınıfta aracı kısa sürede ayırabiliriz.\n\n"
                . "Ulaşım yoğunluğuna göre esnek teslim noktaları planlayarak iş veya seyahat programınızı aksatmadan ilerlemenizi sağlıyoruz.\n\n"
                . "{$pointName} çevresinde avantajlarımız:\n"
                . "- Hızlı teslim ve iade planı\n"
                . "- Farklı segmentlerde araç seçenekleri\n"
                . "- WhatsApp ile kolay rezervasyon\n\n"
                . $cta,
        ];
    }
}
