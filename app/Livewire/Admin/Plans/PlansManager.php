<?php

namespace App\Livewire\Admin\Plans;

use Livewire\Component;
use App\Models\Plan;
use Livewire\WithPagination;
use Laravel\Cashier\Cashier;
use Stripe\Exception\InvalidRequestException;

class PlansManager extends Component
{
    use WithPagination;

    public string $search = '';
    public bool   $showModal    = false;
    public ?int   $editingId    = null;
    

    public string $name         = '';
    public string $description  = '';
    public string $billing_cycle = ''; 
    public string $features     = '';
    public ?float $price        = null; 
    public string $tag          = '';
    public string $stripe_price_id = '';
    
    public ?int $deletingId    = null;
    public string $errorMessage = '';

    public function fetchPrice(): void
    {
        $this->resetErrorBag('stripe_price_id');
        $this->errorMessage = '';

        if (empty($this->stripe_price_id)) {
            $this->errorMessage = 'Please enter a Stripe Price ID to sync.';
            $this->addError('stripe_price_id', $this->errorMessage);

            return;
        }

        try {
            $stripePrice = Cashier::stripe()->prices->retrieve($this->stripe_price_id, [
                'expand' => ['product'],
            ]);

            $this->price = $stripePrice->unit_amount !== null ? $stripePrice->unit_amount / 100 : null;

            if ($stripePrice->recurring && isset($stripePrice->recurring->interval)) {
                $this->billing_cycle = $stripePrice->recurring->interval;
            } else {
                $this->billing_cycle = 'one_time';
            }

            $this->name = $stripePrice->product->name ?? '';

        } catch (InvalidRequestException $e) {
            $this->errorMessage = 'No Stripe price found for this ID. Please check it and try again.';
            $this->price = null;
            $this->billing_cycle = '';
            $this->name = '';
            $this->addError('stripe_price_id', $this->errorMessage);
        } catch (\Exception $e) {
            $this->errorMessage = 'Error connecting to Stripe: ' . $e->getMessage();
            $this->addError('stripe_price_id', $this->errorMessage);
        }
    }

    protected function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:50'],
            'price'           => ['required', 'numeric', 'min:0'],
            'billing_cycle'   => ['required', 'string', 'max:50'],
            'description'     => ['required', 'string', 'max:3000'],
            'features'        => ['required', 'string'],
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
        $this->reset(['name', 'price', 'billing_cycle', 'description', 'tag', 'features', 'stripe_price_id', 'errorMessage']);
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plan = Plan::findOrFail($id);

        $this->editingId       = $plan->id;
        $this->name            = $plan->name;
        $this->billing_cycle   = $plan->billing_cycle;
        
        $this->price           = $plan->price; 
        
        $this->description     = $plan->description ?? '';
        $this->tag             = $plan->tag;
        $this->stripe_price_id = $plan->stripe_price_id;
        $this->features        = is_array($plan->features) ? implode("\n", $plan->features) : $plan->features;
        
        $this->showModal       = true;

        $this->fetchPrice();
    }

    public function save(): void
    {
        if ($this->stripe_price_id && !$this->price) {
            $this->fetchPrice();

            if ($this->errorMessage) {
                return;
            }
        }

        $this->validate();

        $data = [
            'name'            => $this->name,
            'billing_cycle'   => $this->billing_cycle,
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
        $this->reset(['name', 'price', 'billing_cycle', 'description', 'tag', 'features', 'stripe_price_id', 'errorMessage']);
        $this->dispatch('plan-saved');
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