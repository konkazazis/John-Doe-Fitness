<?php

namespace App\Livewire\User\Messages;

use Livewire\Component;

class MessageManager extends Component
{
    public function render()
    {
        return view('livewire.user.messages.messages')->layout('layouts.app', ['title' => 'Messages — CMS']);
    }
}
