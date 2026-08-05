<?php

namespace App\Livewire\Admin\ClientsMessages;

use App\Models\ClientMessage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsMessagesManager extends Component
{
    use WithPagination;

    public ?int $viewing = null;

    public string $reply = '';

    public bool $showNewModal = false;

    public ?int $newUserId = null;

    public string $newMessage = '';

    protected array $rules = [
        'reply' => 'required|string|max:2000',
    ];

    public function view(int $userId): void
    {
        $this->viewing = $userId;

        ClientMessage::where('user_id', $userId)
            ->where('sender', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function close(): void
    {
        $this->viewing = null;
    }

    public function send(): void
    {
        $this->validate();

        ClientMessage::create([
            'user_id' => $this->viewing,
            'sender' => 'admin',
            'message' => $this->reply,
        ]);

        $this->reset('reply');
    }

    public function deleteConversation(int $userId): void
    {
        ClientMessage::where('user_id', $userId)->delete();

        if ($this->viewing === $userId) {
            $this->viewing = null;
        }
    }

    public function openNew(): void
    {
        $this->reset(['newUserId', 'newMessage']);
        $this->resetErrorBag();
        $this->showNewModal = true;
    }

    public function startConversation(): void
    {
        $this->validate([
            'newUserId' => ['required', 'exists:users,id'],
            'newMessage' => ['required', 'string', 'max:2000'],
        ]);

        ClientMessage::create([
            'user_id' => $this->newUserId,
            'sender' => 'admin',
            'message' => $this->newMessage,
        ]);

        $this->viewing = $this->newUserId;
        $this->showNewModal = false;
        $this->reset(['newUserId', 'newMessage']);
    }

    public function render()
    {
        $conversations = User::query()
            ->whereHas('clientMessages')
            ->withMax('clientMessages', 'created_at')
            ->withCount(['clientMessages as unread_count' => function ($query) {
                $query->where('sender', 'user')->where('is_read', false);
            }])
            ->orderByDesc('client_messages_max_created_at')
            ->paginate(20);

        $unreadCount = ClientMessage::where('sender', 'user')->where('is_read', false)->count();

        $currentUser = $this->viewing ? User::find($this->viewing) : null;

        $thread = $this->viewing
            ? ClientMessage::where('user_id', $this->viewing)->oldest()->get()
            : collect();

        $clients = User::whereHas('roles', fn ($q) => $q->where('name', 'user'))
            ->orderBy('username')
            ->get();

        return view('livewire.admin.clients-messages.clients-messages-manager', compact('conversations', 'unreadCount', 'currentUser', 'thread', 'clients'))
            ->layout('layouts.app', ['title' => 'Client Messages']);
    }
}
