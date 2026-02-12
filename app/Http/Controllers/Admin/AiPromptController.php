<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiPrompt;
use Illuminate\Http\Request;

class AiPromptController extends Controller
{
    public function index()
    {
        $prompts = AiPrompt::query()->latest()->paginate(20);

        return view('admin.ai.prompts', compact('prompts'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePrompt($request);
        AiPrompt::query()->create($data);

        return back()->with('status', 'Prompt kaydedildi.');
    }

    public function update(Request $request, int $id)
    {
        $prompt = AiPrompt::query()->findOrFail($id);
        $data = $this->validatePrompt($request, $id);
        $prompt->update($data);

        return back()->with('status', 'Prompt güncellendi.');
    }

    public function destroy(int $id)
    {
        AiPrompt::query()->whereKey($id)->delete();

        return back()->with('status', 'Prompt silindi.');
    }

    private function validatePrompt(Request $request, ?int $id = null): array
    {
        $rule = 'required|string|max:150|unique:ai_prompts,key';
        if ($id) {
            $rule .= ',' . $id;
        }

        return $request->validate([
            'key' => $rule,
            'name' => 'required|string|max:255',
            'system_prompt' => 'required|string',
            'user_prompt_template' => 'required|string',
            'model' => 'required|string|max:120',
            'temperature' => 'required|numeric|min:0|max:2',
            'max_tokens' => 'required|integer|min:100|max:4000',
            'active' => 'required|boolean',
        ]);
    }
}
