<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function show(string $slug)
    {
        $post = Post::published()
            ->with(['user', 'category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('layouts.blog-post', compact('post'));
    }
}
