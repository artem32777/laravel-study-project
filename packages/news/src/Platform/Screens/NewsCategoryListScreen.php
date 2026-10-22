<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Screens;

use Illuminate\Http\Request;
use LaraN\News\Models\NewsCategory;
use LaraN\News\Platform\Layouts\Category\NewsCategoryListLayout;
use LaraN\News\Platform\Layouts\NewsTabMenu;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class NewsCategoryListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'categories' => NewsCategory::query()
                ->orderBy('name')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Новости';
    }

    public function layout(): iterable
    {
        return [
            NewsTabMenu::class,
            NewsCategoryListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        NewsCategory::query()->findOrFail($request->integer('id'))->delete();

        Toast::info('Категория удалена');
    }
}
