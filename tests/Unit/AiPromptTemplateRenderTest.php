<?php

namespace Tests\Unit;

use App\Models\AiPrompt;
use App\Services\Ai\AiClientInterface;
use App\Services\Ai\AiContentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AiPromptTemplateRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_prompt_template_renders_placeholders_and_uses_client(): void
    {
        AiPrompt::query()->create([
            'key' => 'blog_writer_tr',
            'name' => 'Test Prompt',
            'system_prompt' => 'System',
            'user_prompt_template' => '{{title}} | {{city}} | {{keyword}}',
            'model' => 'gpt-4.1-mini',
            'temperature' => 0.70,
            'max_tokens' => 1200,
            'active' => true,
        ]);

        $client = Mockery::mock(AiClientInterface::class);
        $client->shouldReceive('generate')
            ->once()
            ->with('System', 'Başlık | Gebze | araç kiralama', Mockery::type('array'))
            ->andReturn('AI içerik');

        $service = new AiContentService($client);

        $result = $service->generateBlog([
            'title' => 'Başlık',
            'city' => 'Gebze',
            'keyword' => 'araç kiralama',
            'prompt_key' => 'blog_writer_tr',
        ]);

        $this->assertSame('Başlık | Gebze | araç kiralama', $result['rendered_user_prompt']);
        $this->assertSame('AI içerik', $result['content']);
    }
}
