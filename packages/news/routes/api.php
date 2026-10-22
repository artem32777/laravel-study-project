<?php

use Illuminate\Support\Facades\Route;
use LaraN\News\Http\Controllers\Api\NewsCategoryController;
use LaraN\News\Http\Controllers\Api\NewsController;

Route::get('/news', [NewsController::class, 'index'])
    ->name('news.index');

Route::get('/news/{news:slug}', [NewsController::class, 'show'])
    ->name('news.show');

Route::get('/news-categories', [NewsCategoryController::class, 'index'])
    ->name('news-categories.index');
