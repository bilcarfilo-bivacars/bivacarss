<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ai\AiContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class AiGenerateController extends Controller
{
    public function __invoke(Request $request, AiContentService $service): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'city' => 'nullable|string|max:120',
            'keyword' => 'nullable|string|max:120',
            'prompt_key' => 'required|string|exists:ai_prompts,key',
        ]);

        try {
            $result = $service->generateBlog($data);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'content' => $result['content'],
            'rendered_user_prompt' => $result['rendered_user_prompt'],
        ]);
    }
}
