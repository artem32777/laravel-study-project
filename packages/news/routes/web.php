<?php

use Illuminate\Support\Facades\Route;
use LaraN\News\Http\Controllers\NewsController;
use LaraN\News\Platform\Screens\NewsCategoryEditScreen;
use LaraN\News\Platform\Screens\NewsCategoryListScreen;
use LaraN\News\Platform\Screens\NewsEditScreen;
use LaraN\News\Platform\Screens\NewsListScreen;

Route::get('/news', [NewsController::class, 'index'])->name('news.index');

Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/news-api', [NewsController::class, 'client'])->name('news.client');

Route::domain((string) config('platform.domain'))
    ->prefix(config('platform.prefix'))
    ->middleware(config('platform.middleware.private'))
    ->group(function (): void {

        Route::screen('news/create', NewsEditScreen::class)
            ->name('platform.news.create');

        Route::screen('news/list', NewsListScreen::class)
            ->name('platform.news.list');

        Route::screen('news-categories/create', NewsCategoryEditScreen::class)
            ->name('platform.news-categories.create');

        Route::screen('news-categories/list', NewsCategoryListScreen::class)
            ->name('platform.news-categories.list');
    });
