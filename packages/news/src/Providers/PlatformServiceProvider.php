<?php

declare(strict_types=1);

namespace LaraN\News\Providers;

use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformServiceProvider extends OrchidServiceProvider
{
    public function menu(): array
    {
        return [
            Menu::make('Новости')
                ->icon('bs.newspaper')
                ->route('platform.news.create')
                ->active([
                    '*/news/*',
                    '*/news-categories/*',
                ]),
        ];
    }
}
