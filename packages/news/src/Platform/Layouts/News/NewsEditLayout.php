<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Layouts\News;

use LaraN\News\Models\NewsCategory;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class NewsEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('news.title')
                ->title('Заголовок')
                ->required()
                ->max(255),

            Input::make('news.slug')
                ->title('Slug')
                ->required()
                ->max(255)
                ->help('Часть адреса, например novaia-novost. По нему страница откроется как /news/slug'),

            TextArea::make('news.excerpt')
                ->title('Анонс')
                ->rows(3)
                ->required(),

            TextArea::make('news.body')
                ->title('Текст')
                ->rows(8)
                ->required(),

            DateTimer::make('news.published_at')
                ->title('Дата публикации')
                ->enableTime()
                ->allowEmpty()
                ->help('Пустая дата — черновик. На сайте новость появится, когда этот момент уже наступил.'),

            Relation::make('news.categories')
                ->fromModel(NewsCategory::class, 'name')
                ->multiple()
                ->title('Категории'),
        ];
    }
}
