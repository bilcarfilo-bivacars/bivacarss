<?php

namespace App\Services\Ai;

interface AiClientInterface
{
    public function generate(string $systemPrompt, string $userPrompt, array $options = []): string;
}
