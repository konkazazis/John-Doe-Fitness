<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'tag', 'key', 'features',
        'stripe_price_id', 'is_active', 'order',
    ];

    protected $casts = [
        'price' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}