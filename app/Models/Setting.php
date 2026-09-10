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
        return Cache::rememberForever('site.content', function () {
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

    public static function get(string $path, mixed $default = null): mixed
    {
        return Arr::get(static::content(), $path, $default);
    }

    public static function put(string $key, array $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site.content');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.content'));
        static::deleted(fn () => Cache::forget('site.content'));
    }
}
