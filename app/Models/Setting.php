<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['key', 'value'];
    protected $casts = ['value' => 'array'];

    /** All groups merged with config defaults, cached until the next save. */
    public static function content(): array
    {
        // cache key includes a hash of the schema so config edits never serve stale defaults
        return Cache::rememberForever(static::cacheKey(), function () {
            $stored = static::query()->pluck('value', 'key')->all();
            $content = [];
            foreach (config('content.pages') as $page => $pageDef) {
                foreach ($pageDef['groups'] as $group => $groupDef) {
                    $defaults = [];
                    foreach ($groupDef['fields'] as $field) {
                        $defaults[$field['key']] = $field['default'] ?? ($field['type'] === 'text' || $field['type'] === 'textarea' ? '' : []);
                    }
                    $content[$page][$group] = array_merge($defaults, $stored["{$page}.{$group}"] ?? []);
                }
            }

            return $content;
        });
    }

    public static function cacheKey(): string
    {
        return 'site.content.' . md5(serialize(config('content.pages')));
    }

    public static function get(string $path, mixed $default = null): mixed
    {
        return Arr::get(static::content(), $path, $default);
    }

    public static function put(string $key, array $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(static::cacheKey());
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(static::cacheKey()));
        static::deleted(fn () => Cache::forget(static::cacheKey()));
    }
}
