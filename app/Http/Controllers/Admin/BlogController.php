<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::query()->latest()->paginate(20);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.form', ['post' => new BlogPost()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $post = BlogPost::query()->create($data);

        return redirect()->route('admin.blog.edit', $post->id)->with('status', 'Taslak oluşturuldu.');
    }

    public function edit(int $id)
    {
        $post = BlogPost::query()->findOrFail($id);

        return view('admin.blog.form', compact('post'));
    }

    public function update(Request $request, int $id)
    {
        $post = BlogPost::query()->findOrFail($id);
        $data = $this->validated($request, $post->id);

        $post->update($data);

        return back()->with('status', 'Yazı güncellendi.');
    }

    public function publish(int $id)
    {
        $post = BlogPost::query()->findOrFail($id);

        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('status', 'Yazı yayınlandı.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:255|unique:blog_posts,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }
}
