<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'slug',
        'category',
        'client_type',
        'short_description',
        'description',
        'challenge',
        'solution',
        'tech_summary',
        'outcome_stats',
        'cover_image',
        'gallery',
        'external_url',
        'sort_order',
    ];

    protected $casts = [
        'outcome_stats' => 'array',
        'gallery' => 'array',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
