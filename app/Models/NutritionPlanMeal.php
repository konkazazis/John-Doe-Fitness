<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionPlanMeal extends Model
{
    protected $fillable = ['nutrition_plan_id', 'name', 'description', 'calories', 'order'];

    protected $casts = [
        'calories' => 'integer',
        'order' => 'integer',
    ];

    public function nutritionPlan(): BelongsTo
    {
        return $this->belongsTo(NutritionPlan::class);
    }
}
