<?php

namespace App\Livewire\Admin\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PostManager extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    public string $filterStatus = '';

    public string $mode = 'list'; // list | create | edit

    public ?int $editingId = null;

    public string $title = '';

    public string $excerpt = '';

    public string $content = '';

    public string $status = 'draft';

    public ?int $category_id = null;

    public array $selectedTags = [];

    public ?int $deletingId = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'selectedTags' => ['array'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'excerpt', 'content', 'category_id', 'selectedTags']);
        $this->status = 'draft';
        $this->mode = 'create';
        $this->dispatch('post-loaded', content: '');
    }

    public function openEdit(int $id): void
    {
        $post = Post::with('tags')->findOrFail($id);

        $this->editingId = $post->id;
        $this->title = $post->title;
        $this->excerpt = $post->excerpt ?? '';
        $this->content = $post->content;
        $this->status = $post->status;
        $this->category_id = $post->category_id;
        $this->selectedTags = $post->tags->pluck('id')->toArray();
        $this->mode = 'edit';
        $this->dispatch('post-loaded', content: $post->content);
    }

    public function saveContent(string $html): void
    {
        $this->content = $html;
        if ($this->editingId) {
            Post::where('id', $this->editingId)->update(['content' => $html]);
        }
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'title', 'excerpt', 'content', 'category_id', 'selectedTags']);
        $this->status = 'draft';
        $this->mode = 'list';
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->editingId
                ? Post::find($this->editingId)->slug
                : Post::generateSlug($this->title),
            'excerpt' => $this->excerpt ?: null,
            'content' => $this->content,
            'status' => $this->status,
            'category_id' => $this->category_id ?: null,
            'published_at' => $this->status === 'published' ? now() : null,
            'user_id' => auth()->id(),
        ];

        if ($this->editingId) {
            $post = Post::findOrFail($this->editingId);
            $post->update($data);
        } else {
            $post = Post::create($data);
        }

        $post->tags()->sync($this->selectedTags);

        $this->reset(['editingId', 'title', 'excerpt', 'content', 'category_id', 'selectedTags']);
        $this->status = 'draft';
        $this->mode = 'list';
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
        if ($this->deletingId) {
            Post::findOrFail($this->deletingId)->delete();
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $posts = Post::query()
            ->with(['category', 'tags'])
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->latest()
            ->paginate(15);

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $recentPosts = Post::latest()->limit(40)->get(['id', 'title', 'status']);

        return view('livewire.admin.post.post-manager', compact('posts', 'categories', 'tags', 'recentPosts'))
            ->layout('layouts.app', ['title' => 'Posts — CMS']);
    }
}
