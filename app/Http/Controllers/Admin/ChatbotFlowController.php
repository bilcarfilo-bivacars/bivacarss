<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFlow;
use Illuminate\Http\RedirectResponse;

class ChatbotFlowController extends Controller
{
    public function index()
    {
        $flows = ChatbotFlow::query()->orderBy('name')->get();

        return view('admin.chatbot.flows', compact('flows'));
    }

    public function toggle(ChatbotFlow $flow): RedirectResponse
    {
        $flow->update(['active' => ! $flow->active]);

        return redirect()->route('admin.chatbot.flows.index')->with('status', 'Flow güncellendi.');
    }
}
