<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::published()->latest('published_at')->get();
        $categories = Category::whereHas('posts', fn ($q) => $q->published())->orderBy('name')->get();
        $latestPostDate = $posts->first()?->updated_at ?? now();

        return response()
            ->view('sitemap', compact('posts', 'categories', 'latestPostDate'))
            ->header('Content-Type', 'application/xml');
    }
}
