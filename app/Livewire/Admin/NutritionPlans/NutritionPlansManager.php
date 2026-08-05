<?php

namespace App\Livewire\Admin\NutritionPlans;

use App\Models\NutritionPlan;
use App\Models\User;
use Livewire\Component;

class NutritionPlansManager extends Component
{
    public ?int $viewingUserId = null;

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $goal = '';

    public ?int $daily_calories = null;

    public ?int $protein_grams = null;

    public ?int $carbs_grams = null;

    public ?int $fat_grams = null;

    public string $notes = '';

    public bool $is_active = false;

    public array $meals = [];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'goal' => ['nullable', 'string', 'max:150'],
            'daily_calories' => ['nullable', 'integer', 'min:0', 'max:20000'],
            'protein_grams' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'carbs_grams' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'fat_grams' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['boolean'],
            'meals' => ['array'],
            'meals.*.name' => ['required', 'string', 'max:100'],
            'meals.*.description' => ['nullable', 'string', 'max:1000'],
            'meals.*.calories' => ['nullable', 'integer', 'min:0', 'max:5000'],
        ];
    }

    public function selectClient(int $userId): void
    {
        $this->viewingUserId = $userId;
    }

    public function openCreate(): void
    {
        $this->reset([
            'editingId', 'title', 'goal', 'daily_calories', 'protein_grams',
            'carbs_grams', 'fat_grams', 'notes', 'is_active', 'meals',
        ]);
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plan = NutritionPlan::with('meals')->findOrFail($id);

        $this->editingId = $plan->id;
        $this->title = $plan->title;
        $this->goal = $plan->goal ?? '';
        $this->daily_calories = $plan->daily_calories;
        $this->protein_grams = $plan->protein_grams;
        $this->carbs_grams = $plan->carbs_grams;
        $this->fat_grams = $plan->fat_grams;
        $this->notes = $plan->notes ?? '';
        $this->is_active = $plan->is_active;
        $this->meals = $plan->meals->map(fn ($meal) => [
            'name' => $meal->name,
            'description' => $meal->description,
            'calories' => $meal->calories,
        ])->toArray();

        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function addMeal(): void
    {
        $this->meals[] = ['name' => '', 'description' => '', 'calories' => null];
    }

    public function removeMeal(int $index): void
    {
        unset($this->meals[$index]);
        $this->meals = array_values($this->meals);
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'user_id' => $this->viewingUserId,
            'title' => $this->title,
            'goal' => $this->goal ?: null,
            'daily_calories' => $this->daily_calories,
            'protein_grams' => $this->protein_grams,
            'carbs_grams' => $this->carbs_grams,
            'fat_grams' => $this->fat_grams,
            'notes' => $this->notes ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->is_active) {
            NutritionPlan::where('user_id', $this->viewingUserId)
                ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
                ->update(['is_active' => false]);
        }

        $plan = $this->editingId
            ? tap(NutritionPlan::findOrFail($this->editingId))->update($data)
            : NutritionPlan::create($data);

        $plan->meals()->delete();
        foreach (array_values($this->meals) as $order => $meal) {
            $plan->meals()->create([
                'name' => $meal['name'],
                'description' => $meal['description'] ?: null,
                'calories' => $meal['calories'] !== '' ? $meal['calories'] : null,
                'order' => $order,
            ]);
        }

        $this->showModal = false;
    }

    public function activate(int $id): void
    {
        $plan = NutritionPlan::findOrFail($id);

        NutritionPlan::where('user_id', $plan->user_id)->update(['is_active' => false]);
        $plan->update(['is_active' => true]);
    }

    public function delete(int $id): void
    {
        NutritionPlan::findOrFail($id)->delete();
        $this->deletingId = null;
    }

    public function render()
    {
        $clients = User::whereHas('roles', fn ($q) => $q->where('name', 'user'))
            ->withCount('nutritionPlans')
            ->orderBy('username')
            ->get();

        $plans = $this->viewingUserId
            ? NutritionPlan::with('meals')->where('user_id', $this->viewingUserId)->latest()->get()
            : collect();

        $currentClient = $this->viewingUserId ? User::find($this->viewingUserId) : null;

        return view('livewire.admin.nutrition-plans.nutrition-plans-manager', compact('clients', 'plans', 'currentClient'))
            ->layout('layouts.app', ['title' => 'Nutrition Plans']);
    }
}
