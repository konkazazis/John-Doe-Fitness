<?php

namespace App\Livewire\Admin\ExercisePlans;

use App\Models\ExercisePlan;
use App\Models\User;
use Livewire\Component;

class ExercisePlansManager extends Component
{
    public ?int $viewingUserId = null;

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $goal = '';

    public string $notes = '';

    public bool $is_active = false;

    public array $exercises = [];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'goal' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['boolean'],
            'exercises' => ['array'],
            'exercises.*.name' => ['required', 'string', 'max:100'],
            'exercises.*.description' => ['nullable', 'string', 'max:1000'],
            'exercises.*.sets' => ['nullable', 'integer', 'min:0', 'max:100'],
            'exercises.*.reps' => ['nullable', 'integer', 'min:0', 'max:1000'],
            'exercises.*.weight' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function selectClient(int $userId): void
    {
        $this->viewingUserId = $userId;
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'goal', 'notes', 'is_active', 'exercises']);
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plan = ExercisePlan::with('exercises')->findOrFail($id);

        $this->editingId = $plan->id;
        $this->title = $plan->title;
        $this->goal = $plan->goal ?? '';
        $this->notes = $plan->notes ?? '';
        $this->is_active = $plan->is_active;
        $this->exercises = $plan->exercises->map(fn ($exercise) => [
            'name' => $exercise->name,
            'description' => $exercise->description,
            'sets' => $exercise->sets,
            'reps' => $exercise->reps,
            'weight' => $exercise->weight,
        ])->toArray();

        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function addExercise(): void
    {
        $this->exercises[] = ['name' => '', 'description' => '', 'sets' => null, 'reps' => null, 'weight' => ''];
    }

    public function removeExercise(int $index): void
    {
        unset($this->exercises[$index]);
        $this->exercises = array_values($this->exercises);
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'user_id' => $this->viewingUserId,
            'title' => $this->title,
            'goal' => $this->goal ?: null,
            'notes' => $this->notes ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->is_active) {
            ExercisePlan::where('user_id', $this->viewingUserId)
                ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
                ->update(['is_active' => false]);
        }

        $plan = $this->editingId
            ? tap(ExercisePlan::findOrFail($this->editingId))->update($data)
            : ExercisePlan::create($data);

        $plan->exercises()->delete();
        foreach (array_values($this->exercises) as $order => $exercise) {
            $plan->exercises()->create([
                'name' => $exercise['name'],
                'description' => $exercise['description'] ?: null,
                'sets' => $exercise['sets'] !== '' ? $exercise['sets'] : null,
                'reps' => $exercise['reps'] !== '' ? $exercise['reps'] : null,
                'weight' => $exercise['weight'] ?: null,
                'order' => $order,
            ]);
        }

        $this->showModal = false;
    }

    public function activate(int $id): void
    {
        $plan = ExercisePlan::findOrFail($id);

        ExercisePlan::where('user_id', $plan->user_id)->update(['is_active' => false]);
        $plan->update(['is_active' => true]);
    }

    public function delete(int $id): void
    {
        ExercisePlan::findOrFail($id)->delete();
    }

    public function render()
    {
        $clients = User::whereHas('roles', fn ($q) => $q->where('name', 'user'))
            ->withCount('exercisePlans')
            ->orderBy('username')
            ->get();

        $plans = $this->viewingUserId
            ? ExercisePlan::with('exercises')->where('user_id', $this->viewingUserId)->latest()->get()
            : collect();

        $currentClient = $this->viewingUserId ? User::find($this->viewingUserId) : null;

        return view('livewire.admin.exercise-plans.exercise-plans-manager', compact('clients', 'plans', 'currentClient'))
            ->layout('layouts.app', ['title' => 'Exercise Plans']);
    }
}
