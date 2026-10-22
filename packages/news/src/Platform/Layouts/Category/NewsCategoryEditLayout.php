<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Layouts\Category;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class NewsCategoryEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('category.name')
                ->title('Название')
                ->required()
                ->max(255),

            Input::make('category.slug')
                ->title('Slug')
                ->required()
                ->max(255)
                ->help('По этому slug категория выбирается в фильтре на сайте.'),
        ];
    }
}
