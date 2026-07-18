<?php

namespace App\Livewire\Admin\Plans;

use Livewire\Component;
use App\Models\Plan;
use Livewire\WithPagination;

class PlansManager extends Component
{
    use WithPagination;

    public string $search = '';

    public bool   $showModal    = false;
    public ?int   $editingId    = null;
    public string $name         = '';
    public string $key          = '';
    public string $description  = '';
    public string $features     = '';
    public ?int   $price        = null;
    public string $tag          = '';
    public string $stripe_price_id = '';

    public ?int $deletingId = null;

    protected function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:50'],
            'key'             => [
                'required',
                'string',
                'max:50',
                'unique:plans,key' . ($this->editingId ? ",{$this->editingId}" : ''),
            ],
            'price'           => ['required', 'integer', 'min:0'],
            'description'     => ['required', 'string', 'max:3000'],
            'features'        => ['required', 'string', 'max:1000'],
            'tag'             => ['required', 'string', 'max:50'],
            'stripe_price_id' => ['required', 'string', 'max:255'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->editingId = null;
        $this->reset(['name', 'key', 'price', 'description', 'tag', 'features', 'stripe_price_id']);
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plan = Plan::findOrFail($id);

        $this->editingId       = $plan->id;
        $this->name            = $plan->name;
        $this->key             = $plan->key;
        $this->price           = $plan->price;
        $this->description     = $plan->description ?? '';
        $this->tag             = $plan->tag;
        $this->stripe_price_id = $plan->stripe_price_id;
        $this->features        = implode("\n", $plan->features ?? []);
        $this->showModal       = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'            => $this->name,
            'key'             => $this->key,
            'description'     => $this->description,
            'price'           => $this->price,
            'tag'             => $this->tag,
            'stripe_price_id' => $this->stripe_price_id,
            'features'        => collect(explode("\n", $this->features))
                ->map(fn ($line) => trim($line))
                ->filter()
                ->values()
                ->all(),
        ];

        if ($this->editingId) {
            Plan::findOrFail($this->editingId)->update($data);
        } else {
            Plan::create($data);
        }

        $this->showModal = false;
        $this->reset(['name', 'key', 'price', 'description', 'tag', 'features', 'stripe_price_id']);
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
            Plan::findOrFail($this->deletingId)->delete();
            $this->deletingId = null;
        }
    }

    public function render()
    {
        $plans = Plan::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.plans.plans-manager', compact('plans'))
            ->layout('layouts.app', ['title' => 'Plans — CMS']);
    }
}