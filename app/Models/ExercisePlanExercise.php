<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExercisePlanExercise extends Model
{
    protected $fillable = ['exercise_plan_id', 'name', 'description', 'sets', 'reps', 'weight', 'order'];

    protected $casts = [
        'sets' => 'integer',
        'reps' => 'integer',
        'order' => 'integer',
    ];

    public function exercisePlan(): BelongsTo
    {
        return $this->belongsTo(ExercisePlan::class);
    }
}
