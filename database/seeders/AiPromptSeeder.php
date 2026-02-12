<?php

namespace Database\Seeders;

use App\Models\AiPrompt;
use Illuminate\Database\Seeder;

class AiPromptSeeder extends Seeder
{
    public function run(): void
    {
        AiPrompt::query()->updateOrCreate(
            ['key' => 'blog_writer_tr'],
            [
                'name' => 'Türkçe Blog Yazarı',
                'system_prompt' => 'Sen Türkçe içerik üreten bir SEO editörüsün. Doğal, güven verici, spam olmayan içerik yaz. Kullanıcı niyetini karşıla, yerel aramalara uyumlu öneriler sun.',
                'user_prompt_template' => '{{title}} başlığı için Gebze araç kiralama odaklı blog yaz. H1-H2, meta desc, FAQ, Local SEO önerileri.',
                'model' => 'gpt-4.1-mini',
                'temperature' => 0.70,
                'max_tokens' => 1200,
                'active' => true,
            ]
        );
    }
}
