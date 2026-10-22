<?php

namespace LaraN\News\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use LaraN\News\Models\News;
use LaraN\News\Models\NewsCategory;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $authors = User::factory(3)->create();
        $categories = NewsCategory::factory(5)->create();

        News::factory(20)
            ->recycle($authors)
            ->create()
            ->each(function (News $news) use ($categories): void {
                $news->categories()->attach(
                    $categories->random(fake()->numberBetween(1, 3)),
                );
            });

        News::factory(3)
            ->draft()
            ->recycle($authors)
            ->create()
            ->each(function (News $news) use ($categories): void {
                $news->categories()->attach(
                    $categories->random(fake()->numberBetween(1, 2)),
                );
            });

    }
}
