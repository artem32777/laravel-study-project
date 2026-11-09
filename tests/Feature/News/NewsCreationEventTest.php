<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use LaraN\News\Events\NewsCreated;
use LaraN\News\Models\News;

uses(RefreshDatabase::class);

it('dispatches NewsCreated once with the saved news', function () {
    $author = User::factory()->create([
        'permissions' => ['platform.index' => true],
    ]);

    Event::fake([NewsCreated::class]);

    $this->actingAs($author)
        ->post(route('platform.news.create', ['method' => 'save']), [
            'news' => [
                'title' => 'Проверка события',
                'slug' => 'news-event-check',
                'excerpt' => 'Краткое описание новости.',
                'body' => 'Текст новости.',
            ],
        ])
        ->assertRedirect(route('platform.news.create'));

    $savedNews = News::query()
        ->where('slug', 'news-event-check')
        ->firstOrFail();

    Event::assertDispatchedOnce(NewsCreated::class);
    Event::assertDispatched(
        NewsCreated::class,
        fn (NewsCreated $event): bool => $event->news->is($savedNews),
    );
});
