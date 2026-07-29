<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Tag;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $totalProjects = Project::count();
        $publishedProjects = Project::where('is_published', true)->count();
        $totalCategories = Category::count();
        $totalTags = Tag::count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        $totalMessages = ContactMessage::count();

        $recentMessages = ContactMessage::latest()->take(5)->get();

        $recentPosts = Post::latest()->take(5)->get();

        return view('livewire.admin.dashboard', compact(
            'totalPosts', 'publishedPosts', 'totalProjects', 'publishedProjects',
            'totalCategories', 'totalTags', 'unreadMessages', 'totalMessages',
            'recentPosts', 'recentMessages'
        ))->layout('layouts.app', ['title' => 'Overview']);
    }
}
