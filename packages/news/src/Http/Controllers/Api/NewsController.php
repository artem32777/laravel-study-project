<?php

namespace LaraN\News\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use LaraN\News\Exceptions\NewsNotViewableException;
use LaraN\News\Http\Requests\NewsIndexRequest;
use LaraN\News\Http\Resources\NewsResource;
use LaraN\News\Models\News;
use Throwable;

class NewsController extends Controller
{
    public function index(NewsIndexRequest $request): AnonymousResourceCollection
    {
        $title = $request->title();
        $category = $request->category();
        $publishedAt = $request->publishedAt();

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

    /**
     * @throws NewsNotViewableException | Throwable
     */
    public function show(News $news): NewsResource
    {
        throw_unless(Gate::allows('view', $news), NewsNotViewableException::class);

        $news->load(['categories', 'author']);

        return new NewsResource($news);
    }
}
