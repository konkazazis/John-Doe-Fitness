<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'tag', 'features',
    ];

    protected $casts = [
        'price' => 'integer',
        'features' => 'array',
    ];

}
