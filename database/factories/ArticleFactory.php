<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = rtrim($this->faker->sentence(7), '.');

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'category' => $this->faker->randomElement(array_keys(config('content.article_categories'))),
            'excerpt' => $this->faker->sentence(18),
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(5)) . '</p>',
            'tags' => $this->faker->randomElements(['laravel', 'keamanan', 'ux', 'bisnis', 'digital'], 2),
            'status' => 'published',
            'published_at' => now()->subDays($this->faker->numberBetween(1, 60)),
            'is_featured' => false,
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft', 'published_at' => null]);
    }

    public function scheduled(): static
    {
        return $this->state(['status' => 'published', 'published_at' => now()->addDays(3)]);
    }
}
