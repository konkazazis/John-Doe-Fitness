<?php

namespace App\Livewire\User\Messages;

use App\Models\ClientMessage;
use Livewire\Component;

class MessageManager extends Component
{
    public string $message = '';

    protected array $rules = [
        'message' => 'required|string|max:2000',
    ];

    public function mount(): void
    {
        ClientMessage::where('user_id', auth()->id())
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function send(): void
    {
        $this->validate();

        ClientMessage::create([
            'user_id' => auth()->id(),
            'sender' => 'user',
            'message' => $this->message,
        ]);

        $this->reset('message');
    }

    public function render()
    {
        $messages = ClientMessage::where('user_id', auth()->id())
            ->oldest()
            ->get();

        return view('livewire.user.messages.messages', compact('messages'))
            ->layout('layouts.app', ['title' => 'Messages']);
    }
}
