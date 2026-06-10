<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::where('is_published', true)
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->paginate(8);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        abort_unless($post->is_published, 404);

        $post->load(['category', 'tags']);

        return view('posts.show', compact('post'));
    }
}
