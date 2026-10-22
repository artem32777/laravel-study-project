<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use LaraN\News\Models\NewsCategory;
use LaraN\News\Platform\Layouts\Category\NewsCategoryEditLayout;
use LaraN\News\Platform\Layouts\NewsTabMenu;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class NewsCategoryEditScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'category' => new NewsCategory,
        ];
    }

    public function name(): ?string
    {
        return 'Новости';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            NewsTabMenu::class,
            Layout::block(NewsCategoryEditLayout::class)
                ->title('Категория')
                ->description('Категория появится в фильтре на сайте.'),
        ];
    }

    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category.name' => ['required', 'string', 'max:255'],
            'category.slug' => ['required', 'string', 'max:255', Rule::unique(NewsCategory::class, 'slug')],
        ]);

        $category = new NewsCategory;
        $category->fill($validated['category']);
        $category->save();

        Toast::info('Категория сохранена');

        return redirect()->route('platform.news-categories.create');
    }
}
