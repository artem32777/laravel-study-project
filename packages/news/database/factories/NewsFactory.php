<?php

namespace LaraN\News\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use LaraN\News\Models\News;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'body' => fake()->paragraphs(5, true),
            'image' => null,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'published_at' => null,
        ]);
    }
}
