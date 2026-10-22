<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Layouts\Category;

use LaraN\News\Models\NewsCategory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NewsCategoryListLayout extends Table
{
    public $target = 'categories';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', 'Название'),

            TD::make('slug', 'Slug'),

            TD::make('Действия')
                ->render(fn (NewsCategory $category) => Button::make('Удалить')
                    ->icon('bs.trash3')
                    ->confirm('Удалить категорию «'.$category->name.'»?')
                    ->method('remove', [
                        'id' => $category->id,
                    ])),
        ];
    }
}
