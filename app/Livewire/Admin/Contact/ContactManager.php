<?php

namespace App\Livewire\Admin\Contact;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ContactManager extends Component
{
    use WithPagination;

    public ?int $viewing = null;

    public function view(int $id): void
    {
        $this->viewing = $id;
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
    }

    public function close(): void
    {
        $this->viewing = null;
    }

    public function delete(int $id): void
    {
        ContactMessage::findOrFail($id)->delete();
        if ($this->viewing === $id) {
            $this->viewing = null;
        }
    }

    public function render()
    {
        $messages = ContactMessage::latest()->paginate(20);
        $unreadCount = ContactMessage::where('is_read', false)->count();
        $current = $this->viewing ? ContactMessage::find($this->viewing) : null;

        return view('livewire.admin.contact.contact-manager', compact('messages', 'unreadCount', 'current'))
            ->layout('layouts.app', ['title' => 'Messages']);
    }
}
