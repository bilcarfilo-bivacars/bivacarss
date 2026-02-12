<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiPrompt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiPromptApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(AiPrompt::query()->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $prompt = AiPrompt::query()->create($this->validatePrompt($request));

        return response()->json($prompt, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(AiPrompt::query()->findOrFail($id));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $prompt = AiPrompt::query()->findOrFail($id);
        $prompt->update($this->validatePrompt($request, $id));

        return response()->json($prompt->refresh());
    }

    public function destroy(int $id): JsonResponse
    {
        AiPrompt::query()->findOrFail($id)->delete();

        return response()->json([], 204);
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
