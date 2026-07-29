<?php

namespace App\Livewire\Admin\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProjectManager extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    public bool   $showModal     = false;
    public ?int   $editingId     = null;
    public string $title         = '';
    public string $description   = '';
    public bool   $is_published  = false;
    public $cover = null;

    public ?int $deletingId = null;

    protected function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['nullable', 'string', 'max:3000'],
            'is_published' => ['boolean'],
            'cover'        => ['nullable', 'image', 'max:10240'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'description', 'is_published', 'cover']);
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $project = Project::findOrFail($id);

        $this->editingId    = $project->id;
        $this->title        = $project->title;
        $this->description  = $project->description ?? '';
        $this->is_published = $project->is_published;
        $this->cover        = null;
        $this->showModal    = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title'        => $this->title,
            'description'  => $this->description ?: null,
            'is_published' => $this->is_published,
        ];

        if ($this->cover) {
            if ($this->editingId) {
                $old = Project::findOrFail($this->editingId)->cover_image;
                if ($old) {
                    Storage::disk('s3')->delete($old);
                }
            }

            $data['cover_image'] = $this->cover->store('projects/covers', 's3');
        }

        if ($this->editingId) {
            Project::findOrFail($this->editingId)->update($data);
        } else {
            Project::create([
                ...$data,
                'order' => (Project::max('order') ?? 0) + 1,
            ]);
        }

        $this->showModal = false;
        $this->reset(['editingId', 'title', 'description', 'is_published', 'cover']);
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
            $project = Project::findOrFail($this->deletingId);

            if ($project->cover_image) {
                Storage::disk('s3')->delete($project->cover_image);
            }

            $project->delete();
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy('order')
            ->paginate(15);

        return view('livewire.admin.project.project-manager', compact('projects'))
            ->layout('layouts.app', ['title' => 'Projects — CMS']);
    }
}
