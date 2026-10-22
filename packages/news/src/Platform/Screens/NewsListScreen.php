<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Screens;

use Illuminate\Http\Request;
use LaraN\News\Models\News;
use LaraN\News\Platform\Layouts\News\NewsListLayout;
use LaraN\News\Platform\Layouts\NewsTabMenu;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class NewsListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'newsList' => News::query()
                ->latest('id')
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
            NewsListLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        News::query()->findOrFail($request->integer('id'))->delete();

        Toast::info('Новость удалена');
    }
}
