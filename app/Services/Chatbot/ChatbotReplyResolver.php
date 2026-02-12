<?php

namespace App\Services\Chatbot;

use App\Models\ChatbotFlow;
use App\Models\ChatbotMessage;

class ChatbotReplyResolver
{
    public function resolveMainMenuReply(string $normalizedText): string
    {
        $flow = ChatbotFlow::query()
            ->where('key', 'main_menu')
            ->where('active', true)
            ->first();

        if (! $flow) {
            return 'Menü için 1-6 yazın.';
        }

        $messages = ChatbotMessage::query()
            ->where('flow_id', $flow->id)
            ->where('active', true)
            ->orderBy('sort_order')
            ->get();

        $exact = $messages->firstWhere('trigger', $normalizedText);
        if ($exact) {
            return $this->interpolateText($exact->reply_text);
        }

        $containsKeywords = ['merhaba', 'selam', 'menu', 'başla', 'start'];
        foreach ($containsKeywords as $keyword) {
            if (str_contains($normalizedText, $keyword)) {
                $containsMatch = $messages->first(function (ChatbotMessage $message) use ($keyword) {
                    return str_contains($message->trigger, $keyword);
                });

                if ($containsMatch) {
                    return $this->interpolateText($containsMatch->reply_text);
                }
            }
        }

        $mainMenu = $messages->firstWhere('trigger', 'menu') ?? $messages->firstWhere('trigger', 'start');
        if ($mainMenu) {
            return "Menü için 1-6 yazın.\n\n".$this->interpolateText($mainMenu->reply_text);
        }

        return 'Menü için 1-6 yazın.';
    }

    private function interpolateText(string $text): string
    {
        return str_replace('{{maps_url}}', config('bivacars.maps_url'), $text);
    }
}
