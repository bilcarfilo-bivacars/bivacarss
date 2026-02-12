<?php

namespace App\Support;

use App\Models\SeoPage;

class ServiceAreaSeo
{
    public static function build(string $pageType, int $refId, string $name, string $url): array
    {
        $seo = SeoPage::query()->where('page_type', $pageType)->where('ref_id', $refId)->first();

        $title = $seo?->title ?: sprintf('%s Araç Kiralama | BivaCars', $name);
        $description = $seo?->meta_description ?: sprintf('%s bölgesinde günlük ve kurumsal araç kiralama. WhatsApp ile hızlı rezervasyon.', $name);
        $h1 = $seo?->h1 ?: sprintf('%s Araç Kiralama', $name);

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $url,
            'og' => [
                'title' => $title,
                'description' => $description,
                'url' => $url,
            ],
            'h1' => $h1,
            'content' => $seo?->content,
            'faq_json' => $seo?->faq_json,
            'schema_override' => $seo?->schema_override,
        ];
    }
}
