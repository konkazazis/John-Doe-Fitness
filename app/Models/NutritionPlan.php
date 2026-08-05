<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NutritionPlan extends Model
{
    protected $fillable = [
        'user_id', 'title', 'goal', 'daily_calories', 'protein_grams',
        'carbs_grams', 'fat_grams', 'notes', 'is_active',
    ];

    protected $casts = [
        'daily_calories' => 'integer',
        'protein_grams' => 'integer',
        'carbs_grams' => 'integer',
        'fat_grams' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(NutritionPlanMeal::class)->orderBy('order');
    }
}
