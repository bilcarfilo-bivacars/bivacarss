<?php

namespace App\Services\Chatbot;

interface ChatbotProviderInterface
{
    public function sendText(string $to, string $text): void;
}
