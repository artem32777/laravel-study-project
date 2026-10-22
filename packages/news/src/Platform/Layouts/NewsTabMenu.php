<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Layouts;

use Orchid\Screen\Actions\Menu;
use Orchid\Screen\Layouts\TabMenu;

class NewsTabMenu extends TabMenu
{
    /**
     * @return Menu[]
     */
    protected function navigations(): iterable
    {
        return [
            Menu::make('Создать новость')
                ->route('platform.news.create'),
            Menu::make('Список новостей')
                ->route('platform.news.list'),
            Menu::make('Создать категорию')
                ->route('platform.news-categories.create'),
            Menu::make('Список категорий')
                ->route('platform.news-categories.list'),
        ];
    }
}
