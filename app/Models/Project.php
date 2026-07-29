<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'cover_image',
        'order', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function coverUrl(): ?string
    {
        return $this->cover_image ? Storage::disk('s3')->url($this->cover_image) : null;
    }
}
