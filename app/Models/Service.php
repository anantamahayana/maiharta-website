<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'short_description',
        'description',
        'tech_tags',
        'process_steps',
        'meta',
        'capabilities',
        'about_title',
        'sort_order',
    ];

    protected $casts = [
        'tech_tags' => 'array',
        'process_steps' => 'array',
        'meta' => 'array',
        'capabilities' => 'array',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
