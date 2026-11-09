<?php

declare(strict_types=1);

namespace LaraN\News\Platform\Screens;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use LaraN\News\Events\NewsCreated;
use LaraN\News\Models\News;
use LaraN\News\Models\NewsCategory;
use LaraN\News\Platform\Layouts\News\NewsEditLayout;
use LaraN\News\Platform\Layouts\NewsTabMenu;
use LaraN\News\Rules\Slug;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Throwable;

class NewsEditScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'news' => new News,
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
            Layout::block(NewsEditLayout::class)
                ->title('Новость')
                ->description('После сохранения опубликованная новость появится на сайте.'),
        ];
    }

    /**
     * @throws Throwable
     */
    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'news.title' => ['required', 'string', 'max:255'],
            'news.slug' => ['required', 'string', 'max:255', new Slug, Rule::unique(News::class, 'slug')],
            'news.excerpt' => ['required', 'string'],
            'news.body' => ['required', 'string'],
            'news.published_at' => ['nullable', 'date'],
            'news.categories' => ['nullable', 'array'],
            'news.categories.*' => ['integer', Rule::exists(NewsCategory::class, 'id')],
        ]);

        $news = DB::transaction(function () use ($validated, $request): News {
            $news = new News;
            $news->fill($validated['news']);
            $news->author_id = $request->user()->id;
            $news->save();

            $news->categories()->sync($validated['news']['categories'] ?? []);

            return $news;
        });

        NewsCreated::dispatch($news);

        Toast::info('Новость сохранена');

        return redirect()->route('platform.news.create');
    }
}
