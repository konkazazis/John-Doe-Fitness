<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with(['category', 'tags'])
            ->latest('published_at')
            ->take(5)
            ->get();

        $projects = Project::where('is_published', true)
            ->orderBy('order')
            ->get();

        return view('layouts.portfolio', compact('posts', 'projects'));
    }
}

?>