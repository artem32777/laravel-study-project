<?php

namespace LaraN\News\Listeners;

use Illuminate\Support\Facades\Log;
use LaraN\News\Events\NewsCreated;

class LogNewsCreation
{
    /**
     * Handle the event.
     */
    public function handle(NewsCreated $event): void
    {
        $news = $event->news;

        Log::channel('news')->info('Новость создана', [
            'news_id' => $news->id,
            'title' => $news->title,
            'author_id' => $news->author_id,
        ]);
    }
}
