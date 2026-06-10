<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_form_accepts_file_uploads(): void
    {
        $response = $this
            ->actingAs($this->createUser())
            ->get(route('admin.posts.create'));

        $response->assertOk();
        $response->assertSee('enctype="multipart/form-data"', false);
        $response->assertSee('name="image"', false);
    }

    public function test_user_can_create_post_with_image(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        $category = Category::factory()->create();
        $image = UploadedFile::fake()->image('cover.jpg');

        $response = $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), [
                'title' => 'Post con imagen',
                'slug' => 'post-con-imagen',
                'category_id' => $category->id,
                'excerpt' => 'Resumen breve',
                'content' => '<p>Contenido</p>',
                'image' => $image,
            ]);

        $post = Post::query()->where('slug', 'post-con-imagen')->firstOrFail();

        $response->assertRedirect(route('admin.posts.edit', $post));
        $this->assertSame($user->id, $post->user_id);
        $this->assertNotNull($post->image_path);
        Storage::disk('public')->assertExists($post->image_path);
    }

    public function test_user_can_create_post_without_image(): void
    {
        Storage::fake('public');

        $user = $this->createUser();
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('admin.posts.store'), [
                'title' => 'Post sin imagen',
                'slug' => 'post-sin-imagen',
                'category_id' => $category->id,
            ]);

        $post = Post::query()->where('slug', 'post-sin-imagen')->firstOrFail();

        $response->assertRedirect(route('admin.posts.edit', $post));
        $this->assertNull($post->image_path);
        Storage::disk('public')->assertDirectoryEmpty('posts');
    }

    private function createUser(): User
    {
        return User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
    }
}
