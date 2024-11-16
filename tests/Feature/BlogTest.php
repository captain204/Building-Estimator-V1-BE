<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_blog_post()
    {
        $data = [
            'title' => 'Test Blog Title',
            'content' => 'This is a test blog content.',
        ];

        $response = $this->postJson('/blog', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Blog created successfully']);
        $this->assertDatabaseHas('blogs', $data);
    }

    /** @test */
    public function it_can_show_all_blog_posts()
    {
        Blog::factory()->count(3)->create();

        $response = $this->getJson('/blog');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_show_a_single_blog_post()
    {
        $blog = Blog::factory()->create();

        $response = $this->getJson("/blog/{$blog->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $blog->id,
                     'title' => $blog->title,
                     'content' => $blog->content,
                 ]);
    }

    /** @test */
    public function it_can_update_a_blog_post()
    {
        $blog = Blog::factory()->create();
        $updatedData = [
            'title' => 'Updated Blog Title',
            'content' => 'Updated blog content.',
        ];

        $response = $this->putJson("/blog/{$blog->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Blog updated successfully']);
        $this->assertDatabaseHas('blogs', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_blog_post()
    {
        $blog = Blog::factory()->create();

        $response = $this->deleteJson("/blog/{$blog->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Blog deleted successfully']);
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }
}
