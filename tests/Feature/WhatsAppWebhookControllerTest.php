<?php

namespace Tests\Feature;

use App\Models\ChatbotFlow;
use App\Models\ChatbotMessage;
use App\Services\Chatbot\ChatbotProviderInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsAppWebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_trigger_five_builds_reply_with_maps_url(): void
    {
        config()->set('bivacars.maps_url', 'https://maps.example.com/biva');

        $flow = ChatbotFlow::query()->create([
            'key' => 'main_menu',
            'name' => 'Ana Menü',
            'active' => true,
        ]);

        ChatbotMessage::query()->create([
            'flow_id' => $flow->id,
            'trigger' => '5',
            'reply_text' => 'Yol tarifi: {{maps_url}}',
            'reply_type' => 'text',
            'sort_order' => 0,
            'active' => true,
        ]);

        $fakeProvider = new class implements ChatbotProviderInterface {
            public string $to = '';
            public string $text = '';

            public function sendText(string $to, string $text): void
            {
                $this->to = $to;
                $this->text = $text;
            }
        };

        $this->app->instance(ChatbotProviderInterface::class, $fakeProvider);

        $payload = [
            'entry' => [[
                'changes' => [[
                    'value' => [
                        'messages' => [[
                            'from' => '905555551111',
                            'text' => ['body' => '5'],
                        ]],
                    ],
                ]],
            ]],
        ];

        $this->postJson('/webhooks/whatsapp', $payload)->assertOk();

        $this->assertSame('905555551111', $fakeProvider->to);
        $this->assertStringContainsString('https://maps.example.com/biva', $fakeProvider->text);
    }
}
