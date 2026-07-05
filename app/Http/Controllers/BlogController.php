<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $categorySlug = request('category');
        $search = trim(request('search', ''));

        $posts = Post::published()
            ->with(['user', 'category', 'tags'])
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($q) => $q->where('slug', $categorySlug)))
            ->when($search, function ($q) use ($search) {
                $term = '%' . strtolower($search) . '%';
                $q->where(fn($q) => $q
                    ->whereRaw('LOWER(title) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(excerpt) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(content) LIKE ?', [$term])
                );
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::whereHas('posts', fn($q) => $q->published())
            ->orderBy('name')
            ->get();

        $activeCategory = $categories->firstWhere('slug', $categorySlug);

        return view('layouts.blog', compact('posts', 'categories', 'activeCategory', 'search'));
    }
}
