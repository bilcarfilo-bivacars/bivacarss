<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\ChatbotLog;
use App\Services\Chatbot\ChatbotProviderInterface;
use App\Services\Chatbot\ChatbotReplyResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WhatsAppWebhookController extends Controller
{
    public function verify(Request $request)
    {
        if ($request->query('hub_mode') === null && $request->query('hub.mode') !== null) {
            // no-op, keep compatibility in local manual testing tools
        }

        $mode = $request->query('hub.mode');
        $token = $request->query('hub.verify_token');
        $challenge = $request->query('hub.challenge');

        if ($mode === 'subscribe' && $token === env('WHATSAPP_VERIFY_TOKEN')) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }

    public function receive(Request $request, ChatbotProviderInterface $provider, ChatbotReplyResolver $resolver): JsonResponse
    {
        $payload = $request->all();
        $messageText = data_get($payload, 'entry.0.changes.0.value.messages.0.text.body');
        $fromPhone = data_get($payload, 'entry.0.changes.0.value.messages.0.from', 'unknown');

        ChatbotLog::query()->create([
            'provider' => 'whatsapp_cloud',
            'from_phone' => $fromPhone,
            'message_text' => $messageText,
            'payload_json' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
        ]);

        if (! $messageText) {
            return response()->json(['ok' => true]);
        }

        $normalized = mb_strtolower(trim($messageText));
        $reply = $resolver->resolveMainMenuReply($normalized);

        $provider->sendText($fromPhone, $reply);

        return response()->json(['ok' => true]);
    }
}
