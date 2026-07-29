<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class TestimonialManager extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $client = '';

    public string $description = '';

    public string $quote = '';

    public bool $is_published = false;

    public $cover = null;

    public ?int $deletingId = null;

    protected function rules(): array
    {
        return [
            'client' => ['required', 'string', 'max:50'],
            'quote' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:3000'],
            'is_published' => ['boolean'],
            'cover' => ['nullable', 'image', 'max:10240'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'client', 'description', 'quote', 'is_published', 'cover']);
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $testimonial = Testimonial::findOrFail($id);

        $this->editingId = $testimonial->id;
        $this->client = $testimonial->client;
        $this->quote = $testimonial->quote;
        $this->description = $testimonial->description ?? '';
        $this->is_published = $testimonial->is_published;
        $this->cover = null;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'client' => $this->client,
            'description' => $this->description ?: null,
            'quote' => $this->quote ?: null,
            'is_published' => $this->is_published,
        ];

        if ($this->cover) {
            if ($this->editingId) {
                $old = Testimonial::findOrFail($this->editingId)->cover_image;
                if ($old) {
                    Storage::disk('s3')->delete($old);
                }
            }

            $data['cover_image'] = $this->cover->store('testimonials/covers', 's3');
        }

        if ($this->editingId) {
            Testimonial::findOrFail($this->editingId)->update($data);
        } else {
            Testimonial::create([
                ...$data,
                'order' => (Testimonial::max('order') ?? 0) + 1,
            ]);
        }

        $this->showModal = false;
        $this->reset(['editingId', 'client', 'description', 'quote', 'is_published', 'cover']);
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
            $testimonial = Testimonial::findOrFail($this->deletingId);

            if ($testimonial->cover_image) {
                Storage::disk('s3')->delete($testimonial->cover_image);
            }

            $testimonial->delete();
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $testimonials = Testimonial::query()
            ->when($this->search, fn ($q) => $q->where('client', 'like', "%{$this->search}%"))
            ->orderBy('order')
            ->paginate(15);

        return view('livewire.admin.testimonials.testimonials-manager', compact('testimonials'))
            ->layout('layouts.app', ['title' => 'Testimonials — CMS']);
    }
}
