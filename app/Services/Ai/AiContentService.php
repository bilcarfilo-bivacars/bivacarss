<?php

namespace App\Services\Ai;

use App\Models\AiPrompt;
use RuntimeException;

class AiContentService
{
    public function __construct(private readonly AiClientInterface $client)
    {
    }

    public function generateBlog(array $input): array
    {
        $prompt = AiPrompt::query()
            ->where('key', $input['prompt_key'])
            ->where('active', true)
            ->firstOrFail();

        $title = trim((string) ($input['title'] ?? ''));
        if ($title === '') {
            throw new RuntimeException('Başlık zorunludur.');
        }

        $renderedUserPrompt = $this->renderTemplate($prompt->user_prompt_template, [
            'title' => $title,
            'city' => (string) ($input['city'] ?? ''),
            'keyword' => (string) ($input['keyword'] ?? ''),
        ]);

        $content = $this->client->generate(
            $prompt->system_prompt,
            $renderedUserPrompt,
            [
                'model' => $prompt->model,
                'temperature' => (float) $prompt->temperature,
                'max_tokens' => (int) $prompt->max_tokens,
            ]
        );

        return [
            'prompt' => $prompt,
            'rendered_user_prompt' => $renderedUserPrompt,
            'content' => $content,
        ];
    }

    public function renderTemplate(string $template, array $variables): string
    {
        return preg_replace_callback('/{{\s*(\w+)\s*}}/', function ($matches) use ($variables) {
            $key = $matches[1];
            return (string) ($variables[$key] ?? '');
        }, $template) ?? $template;
    }
}
