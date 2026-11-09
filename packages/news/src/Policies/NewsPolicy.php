<?php

namespace LaraN\News\Policies;

use App\Models\User;
use LaraN\News\Models\News;

class NewsPolicy
{
    public function view(?User $user, News $news): bool
    {
        if ($news->published_at !== null && ! $news->published_at->isFuture()) {
            return true;
        }

        return $user?->id === $news->author_id;
    }
}
