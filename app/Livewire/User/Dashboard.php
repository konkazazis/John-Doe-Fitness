<?php

namespace App\Livewire\User;

//use App\Models\Message;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // $unreadMessages  = ContactMessage::where('is_read', false)->count();
        // $totalMessages   = ContactMessage::count();

        // $recentMessages = ContactMessage::latest()->take(5)->get();

        // return view('livewire.user.dashboard', compact(
        //     'unreadMessages', 'totalMessages', 'recentMessages'
        // ))->layout('layouts.app', ['title' => 'Overview — CMS']);

            return view('livewire.user.dashboard')->layout('layouts.app', ['title' => 'Overview — CMS']);
        
    }
}
