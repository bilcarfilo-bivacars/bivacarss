<?php

namespace Database\Seeders;

use App\Models\ChatbotFlow;
use Illuminate\Database\Seeder;

class ChatbotSeeder extends Seeder
{
    public function run(): void
    {
        $flow = ChatbotFlow::query()->updateOrCreate(
            ['key' => 'main_menu'],
            ['name' => 'Ana Menü', 'active' => true]
        );

        $mainMenuText = "BivaCars WhatsApp Menüsü:\n"
            ."1) Kurumsal Kiralama\n"
            ."2) Günlük Kiralama\n"
            ."4) Hizmet Bölgeleri\n"
            ."5) Yol Tarifi\n"
            ."6) İş Ortağı Başvurusu";

        $messages = [
            ['trigger' => 'start', 'reply_text' => $mainMenuText, 'sort_order' => 10],
            ['trigger' => 'merhaba', 'reply_text' => $mainMenuText, 'sort_order' => 11],
            ['trigger' => 'menu', 'reply_text' => $mainMenuText, 'sort_order' => 12],
            ['trigger' => '5', 'reply_text' => 'Yol tarifi için: {{maps_url}}', 'sort_order' => 20],
            ['trigger' => '6', 'reply_text' => 'İş ortağı olmak için: /aracimi-kiraya-vermek-istiyorum', 'reply_type' => 'link', 'sort_order' => 30],
            ['trigger' => '1', 'reply_text' => 'Kurumsal kiralama çözümleri: /kurumsal-kiralama', 'reply_type' => 'link', 'sort_order' => 40],
            ['trigger' => '2', 'reply_text' => 'Günlük araçlar ve fiyatlar: /araclar', 'reply_type' => 'link', 'sort_order' => 50],
            ['trigger' => '4', 'reply_text' => 'Hizmet bölgeleri: /hizmet-bolgeleri', 'reply_type' => 'link', 'sort_order' => 60],
        ];

        foreach ($messages as $payload) {
            $flow->messages()->updateOrCreate(
                ['trigger' => $payload['trigger']],
                [
                    'reply_text' => $payload['reply_text'],
                    'reply_type' => $payload['reply_type'] ?? 'text',
                    'meta_json' => $payload['meta_json'] ?? null,
                    'sort_order' => $payload['sort_order'] ?? 0,
                    'active' => true,
                ]
            );
        }
    }
}
