<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFlow;
use App\Models\ChatbotMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChatbotMessageController extends Controller
{
    public function index(ChatbotFlow $flow)
    {
        $messages = $flow->messages()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.chatbot.messages', compact('flow', 'messages'));
    }

    public function store(Request $request, ChatbotFlow $flow): RedirectResponse
    {
        $data = $request->validate([
            'trigger' => ['required', 'string', 'max:255'],
            'reply_text' => ['required', 'string'],
            'reply_type' => ['required', 'in:text,template,link'],
            'meta_json' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'active' => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $flow->messages()->create($data);

        return back()->with('status', 'Mesaj oluşturuldu.');
    }

    public function update(Request $request, ChatbotFlow $flow, ChatbotMessage $message): RedirectResponse
    {
        abort_unless($message->flow_id === $flow->id, 404);

        $data = $request->validate([
            'trigger' => ['required', 'string', 'max:255'],
            'reply_text' => ['required', 'string'],
            'reply_type' => ['required', 'in:text,template,link'],
            'meta_json' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'active' => ['nullable', 'boolean'],
        ]);

        $data['active'] = $request->boolean('active', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $message->update($data);

        return back()->with('status', 'Mesaj güncellendi.');
    }
}
