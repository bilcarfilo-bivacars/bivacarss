<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceAreasSeeder extends Seeder
{
    public function run(): void
    {
        $industrialCities = [
            'kocaeli' => 'Kocaeli',
            'istanbul-anadolu' => 'İstanbul Anadolu Yakası',
            'bursa' => 'Bursa',
            'tekirdag' => 'Tekirdağ',
            'izmir' => 'İzmir',
            'ankara' => 'Ankara',
            'gaziantep' => 'Gaziantep',
            'konya' => 'Konya',
            'kayseri' => 'Kayseri',
            'mersin' => 'Mersin',
            'adana' => 'Adana',
            'manisa' => 'Manisa',
            'sakarya' => 'Sakarya',
            'eskisehir' => 'Eskişehir',
            'denizli' => 'Denizli',
        ];

        $cityIds = [];
        foreach ($industrialCities as $slug => $name) {
            if ($slug === 'istanbul-anadolu' && DB::table('cities')->where('slug', 'istanbul-anadolu')->exists()) {
                $cityIds[$slug] = (int) DB::table('cities')->where('slug', 'istanbul-anadolu')->value('id');
                continue;
            }

            DB::table('cities')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'region_group' => 'industrial', 'created_at' => now(), 'updated_at' => now()]
            );

            $cityIds[$slug] = (int) DB::table('cities')->where('slug', $slug)->value('id');
        }

        $industries = [
            'insaat' => 'İnşaat Firmaları',
            'lojistik' => 'Lojistik / Nakliye',
            'uretim' => 'Üretim / Fabrika',
            'otomotiv' => 'Otomotiv / Yan Sanayi',
            'teknoloji' => 'Teknoloji / Yazılım',
            'gida' => 'Gıda / Tedarik',
            'enerji' => 'Enerji / Saha Ekipleri',
            'saglik' => 'Sağlık Kurumları',
            'turizm' => 'Turizm / Otel',
            'kamu' => 'Kamu / Belediyeler',
        ];

        $industryIds = [];
        $i = 0;
        foreach ($industries as $key => $name) {
            DB::table('industries')->updateOrInsert(
                ['key' => $key],
                ['name' => $name, 'description' => $name.' için optimize edilen kurumsal filo yönetimi.', 'active' => true, 'sort_order' => $i++, 'created_at' => now(), 'updated_at' => now()]
            );
            $industryIds[$key] = (int) DB::table('industries')->where('key', $key)->value('id');

            $this->upsertSeoPage('industry', $industryIds[$key], [
                'title' => $name.' için Kurumsal Filo Kiralama | BivaCars',
                'description' => $name.' firmaları için yıllık kiralama ve filo operasyon desteği.',
                'content' => $this->buildIndustryContent($name),
            ]);
        }

        $matches = [
            'kocaeli' => ['insaat', 'lojistik', 'uretim', 'otomotiv'],
            'istanbul-anadolu' => ['insaat', 'lojistik', 'teknoloji'],
            'bursa' => ['uretim', 'otomotiv', 'lojistik'],
            'tekirdag' => ['uretim', 'lojistik'],
            'izmir' => ['lojistik', 'teknoloji', 'uretim'],
            'ankara' => ['kamu', 'teknoloji', 'insaat'],
            'gaziantep' => ['uretim', 'lojistik'],
            'konya' => ['uretim', 'otomotiv'],
            'kayseri' => ['uretim', 'otomotiv'],
            'manisa' => ['uretim', 'otomotiv'],
            'sakarya' => ['uretim', 'otomotiv'],
            'mersin' => ['lojistik', 'turizm'],
            'adana' => ['lojistik', 'turizm'],
        ];

        $introPool = [
            'Bölgesel operasyonlar için hızlı teslim ve kurumsal SLA odaklı filo planları sunuyoruz.',
            'Sektöre özel maliyet kontrolü ve saha verimliliği için optimize edilen kiralama modeli.',
            'Talep yoğunluğuna göre ölçeklenen araç havuzu ile iş sürekliliğini destekliyoruz.',
        ];
        $bulletPool = [
            [
                'Hızlı araç tahsisi ve süreç takibi',
                'Operasyonel maliyet optimizasyonu',
                'Tek noktadan teklif ve sözleşme yönetimi',
            ],
            [
                'Kurumsal faturalama ve raporlama',
                'Bölgesel teslimat koordinasyonu',
                'Uzun dönem filo planlama desteği',
            ],
        ];
        $ctaPool = ['Hemen teklif alın.', 'WhatsApp üzerinden hızlı fiyat isteyin.'];

        foreach ($matches as $citySlug => $industryKeys) {
            foreach ($industryKeys as $index => $industryKey) {
                $cityId = $cityIds[$citySlug] ?? null;
                $industryId = $industryIds[$industryKey] ?? null;
                if (! $cityId || ! $industryId) {
                    continue;
                }

                DB::table('city_industries')->updateOrInsert(
                    ['city_id' => $cityId, 'industry_id' => $industryId],
                    ['active' => true, 'sort_order' => $index, 'created_at' => now(), 'updated_at' => now()]
                );

                $pivotId = (int) DB::table('city_industries')->where('city_id', $cityId)->where('industry_id', $industryId)->value('id');
                $cityName = $industrialCities[$citySlug];
                $industryName = $industries[$industryKey];

                $bullets = $bulletPool[$index % count($bulletPool)];
                $content = $introPool[$index % count($introPool)]."\n\n";
                $content .= "- {$bullets[0]}\n- {$bullets[1]}\n- {$bullets[2]}\n\n";
                $content .= $ctaPool[$index % count($ctaPool)];

                $this->upsertSeoPage('city_industry', $pivotId, [
                    'title' => $cityName.' '.$industryName.' Filo Kiralama | BivaCars',
                    'description' => $cityName.' bölgesinde '.$industryName.' firmalarına yıllık kurumsal kiralama çözümleri.',
                    'content' => $content,
                ]);
            }
        }
    }

    private function upsertSeoPage(string $pageType, int $refId, array $data): void
    {
        DB::table('seo_pages')->updateOrInsert(
            ['page_type' => $pageType, 'ref_id' => $refId, 'locale' => 'tr'],
            [
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'content' => $data['content'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function buildIndustryContent(string $industryName): string
    {
        return $industryName." ekiplerinin sahadaki mobilite ihtiyacına göre planlanan kiralama çözümleri sunuyoruz.\n\n- Operasyon temposuna uygun araç yapısı\n- Bütçe odaklı esnek paketler\n- Tekliften teslimata hızlı süreç";
    }
}
