<?php

namespace LaraN\News\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use LaraN\News\Exceptions\NewsNotViewableException;
use LaraN\News\Http\Requests\NewsIndexRequest;
use LaraN\News\Models\News;
use LaraN\News\Models\NewsCategory;
use Throwable;

class NewsController extends Controller
{
    public function index(NewsIndexRequest $request): View
    {
        $title = $request->title();
        $category = $request->category();
        $publishedAt = $request->publishedAt();

        $newsList = News::query()
            ->published()
            ->when(
                $category !== '',
                fn (Builder $query) => $query->whereHas(
                    'categories',
                    fn (Builder $query) => $query->where('slug', $category),
                ),
            )
            ->when(
                $title !== '',
                fn (Builder $query) => $query->where('title', 'ilike', "%{$title}%"),
            )
            ->when(
                $publishedAt !== null,
                fn (Builder $query) => $query->whereDate('published_at', $publishedAt),
            )
            ->with(['categories', 'author'])
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        $categories = NewsCategory::query()
            ->orderBy('name')->get();

        return view('news::index', [
            'newsList' => $newsList,
            'categories' => $categories,
        ]);
    }

    /**
     * @throws NewsNotViewableException | Throwable
     */
    public function show(News $news): View
    {
        throw_unless(Gate::allows('view', $news), NewsNotViewableException::class);

        $news->load(['categories', 'author']);

        return view('news::show', ['news' => $news]);
    }

    public function client(): View
    {
        return view('news::client');
    }
}
