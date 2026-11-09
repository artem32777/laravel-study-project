<?php

declare(strict_types=1);

namespace LaraN\News\Events;

use Illuminate\Foundation\Events\Dispatchable;
use LaraN\News\Models\News;

class NewsCreated
{
    use Dispatchable;

    public function __construct(
        public News $news,
    ) {}
}
