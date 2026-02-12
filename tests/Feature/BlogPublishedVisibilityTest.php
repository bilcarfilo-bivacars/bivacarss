<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPublishedVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_published_posts_are_listed_on_blog_page(): void
    {
        BlogPost::query()->create([
            'title' => 'Yayınlı Yazı',
            'slug' => 'yayinli-yazi',
            'content' => 'İçerik',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        BlogPost::query()->create([
            'title' => 'Taslak Yazı',
            'slug' => 'taslak-yazi',
            'content' => 'İçerik',
            'status' => 'draft',
        ]);

        $response = $this->get('/blog');

        $response->assertOk();
        $response->assertSee('Yayınlı Yazı');
        $response->assertDontSee('Taslak Yazı');
    }
}
