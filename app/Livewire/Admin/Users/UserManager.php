<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterRole = '';

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $username = '';

    public string $email = '';

    public array $selectedRoles = [];

    public ?int $deletingId = null;

    public string $errorMessage = '';

    protected function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->editingId)],
            'selectedRoles' => ['required', 'array', 'min:1'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->editingId = null;
        $this->reset(['username', 'email', 'selectedRoles', 'errorMessage']);
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $user = User::with('roles')->findOrFail($id);

        $this->editingId = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->errorMessage = '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId && ! in_array('admin', $this->selectedRoles, true) && $this->isLastAdmin(User::findOrFail($this->editingId))) {
            $this->errorMessage = 'This is the last remaining admin — assign another admin before removing this role.';

            return;
        }

        if ($this->editingId) {
            $user = User::findOrFail($this->editingId);
            $user->update([
                'username' => $this->username,
                'email' => $this->email,
            ]);
        } else {
            $temporaryPassword = Str::random(24);

            $user = User::create([
                'username' => $this->username,
                'email' => $this->email,
                'password' => Hash::make($temporaryPassword),
                'must_change_password' => true,
            ]);

            Password::sendResetLink(['email' => $user->email]);
        }

        $user->roles()->sync(
            Role::whereIn('name', $this->selectedRoles)->pluck('id', 'name')
        );

        $this->showModal = false;
        $this->reset(['username', 'email', 'selectedRoles', 'errorMessage']);
    }

    public function toggleActive(int $id): void
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            $this->errorMessage = "You can't deactivate your own account.";

            return;
        }

        if ($user->is_active && $this->isLastAdmin($user)) {
            $this->errorMessage = 'This is the last remaining admin — assign another admin before deactivating this account.';

            return;
        }

        $user->update(['is_active' => ! $user->is_active]);
        $this->errorMessage = '';
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId = $id;
    }

    public function cancelDelete(): void
    {
        $this->deletingId = null;
    }

    public function delete(): void
    {
        if (! $this->deletingId) {
            return;
        }

        $user = User::findOrFail($this->deletingId);

        if ($user->id === auth()->id()) {
            $this->errorMessage = "You can't delete your own account.";
            $this->deletingId = null;

            return;
        }

        if ($this->isLastAdmin($user)) {
            $this->errorMessage = 'This is the last remaining admin — assign another admin before deleting this account.';
            $this->deletingId = null;

            return;
        }

        $user->subscriptions()->active()->get()->each->cancelNow();
        $user->roles()->detach();
        $user->delete();

        $this->deletingId = null;
    }

    private function isLastAdmin(User $user): bool
    {
        if (! $user->role('admin')) {
            return false;
        }

        return User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->count() <= 1;
    }

    public function render()
    {
        $users = User::query()
            ->with('roles')
            ->when($this->search, fn ($q) => $q->where(fn ($q) => $q
                ->where('username', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            ))
            ->when($this->filterRole, fn ($q) => $q->whereHas('roles', fn ($q) => $q->where('name', $this->filterRole)))
            ->orderBy('username')
            ->paginate(15);

        $roles = Role::orderBy('name')->get();

        $adminCount = User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->count();

        $deletingUser = $this->deletingId ? User::find($this->deletingId) : null;
        $deletingPostsCount = $deletingUser ? $deletingUser->posts()->count() : 0;

        return view('livewire.admin.users.user-manager', compact('users', 'roles', 'adminCount', 'deletingUser', 'deletingPostsCount'))
            ->layout('layouts.app', ['title' => 'Users']);
    }
}
