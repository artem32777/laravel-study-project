<?php

namespace LaraN\News\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use LaraN\News\Http\Resources\NewsResource;
use LaraN\News\Models\News;

class NewsController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'category' => ['nullable', 'string', 'max:255'],
        ]);

        $title = trim($validated['title'] ?? '');
        $publishedAt = $validated['published_at'] ?? null;
        $category = trim($validated['category'] ?? '');

        $newsList = News::query()
            ->published()
            ->when(
                $title !== '',
                fn (Builder $query) => $query->where(
                    'title',
                    'ilike',
                    "%{$title}%",
                ),
            )
            ->when(
                $category !== '',
                fn (Builder $query) => $query->whereHas(
                    'categories',
                    fn (Builder $query) => $query->where('slug', $category),
                ),
            )
            ->when(
                $publishedAt !== null,
                fn (Builder $query) => $query->whereDate('published_at', $publishedAt),
            )
            ->with(['categories', 'author'])
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return NewsResource::collection($newsList);
    }

    public function show(News $news): NewsResource
    {
        abort_if(
            $news->published_at === null || $news->published_at->isFuture(),
            404,
        );

        $news->load(['categories', 'author']);

        return new NewsResource($news);
    }
}
