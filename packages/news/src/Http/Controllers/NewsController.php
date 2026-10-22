<?php

namespace LaraN\News\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use LaraN\News\Models\News;
use LaraN\News\Models\NewsCategory;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlugs = $request->collect('category')->filter()->values();
        $title = $request->string('title')->trim()->toString();
        $publishedAt = $request->date('published_at');

        $newsList = News::query()
            ->published()
            ->when(
                $categorySlugs->isNotEmpty(),
                fn (Builder $query) => $query->whereHas(
                    'categories',
                    fn (Builder $query) => $query->whereIn('slug', $categorySlugs),
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
            ->orderBy('name')
            ->get();

        return view('news::index', [
            'newsList' => $newsList,
            'categories' => $categories,
        ]);
    }

    public function show(News $news): View
    {
        abort_if($news->published_at === null || $news->published_at->isFuture(), 404);

        $news->load(['categories', 'author']);

        return view('news::show', ['news' => $news]);
    }

    public function client(): View
    {
        return view('news::client');
    }
}
