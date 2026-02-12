<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiPrompt;
use App\Models\BlogPost;
use App\Services\Ai\AiContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;

class AiContentController extends Controller
{
    public function index()
    {
        $prompts = AiPrompt::query()->where('active', true)->orderBy('name')->get();

        return view('admin.ai.generator', [
            'prompts' => $prompts,
            'generated' => old('generated_content'),
            'apiKeyMissing' => blank(config('ai.openai.api_key')),
        ]);
    }

    public function generate(Request $request, AiContentService $service)
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
            return back()->withInput()->withErrors(['ai' => $e->getMessage()]);
        }

        return back()->withInput()->with('generated_content', $result['content']);
    }

    public function createDraft(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'generated_content' => 'required|string',
        ]);

        $post = BlogPost::query()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::random(5),
            'content' => $data['generated_content'],
            'status' => 'draft',
        ]);

        return redirect()->route('admin.blog.edit', $post->id)->with('status', 'AI taslağı oluşturuldu.');
    }
}
