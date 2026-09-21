<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    public const STATUSES = ['draft' => 'Draft', 'published' => 'Tayang'];

    protected $fillable = [
        'user_id', 'title', 'slug', 'category', 'excerpt', 'body', 'cover',
        'tags', 'status', 'published_at', 'is_featured', 'views',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Tayang untuk publik: status published dan jadwal sudah lewat. */
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeLatestPublished(Builder $q): Builder
    {
        return $q->published()->orderByDesc('published_at');
    }

    public function isLive(): bool
    {
        return $this->status === 'published' && $this->published_at && $this->published_at->lte(now());
    }

    /** Label status untuk admin: Draft / Terjadwal / Tayang. */
    public function statusLabel(): string
    {
        if ($this->status !== 'published') return 'Draft';

        return $this->published_at && $this->published_at->isFuture() ? 'Terjadwal' : 'Tayang';
    }

    /** Perkiraan waktu baca (±200 kata/menit), minimal 1 menit. */
    public function readingMinutes(): int
    {
        $words = str_word_count(strip_tags($this->body));

        return max(1, (int) ceil($words / 200));
    }

    public static function categories(): array
    {
        return config('content.article_categories', []);
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
