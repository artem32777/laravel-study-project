<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Layouts\News;

use LaraN\News\Models\News;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NewsListLayout extends Table
{
    public $target = 'newsList';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', 'Заголовок'),

            TD::make('slug', 'Slug'),

            TD::make('published_at', 'Дата публикации')
                ->render(fn (News $news) => $news->published_at?->format('d.m.Y H:i') ?? 'Черновик'),

            TD::make('Действия')
                ->render(fn (News $news) => Button::make('Удалить')
                    ->icon('bs.trash3')
                    ->confirm('Удалить новость «'.$news->title.'»?')
                    ->method('remove', [
                        'id' => $news->id,
                    ])),
        ];
    }
}
