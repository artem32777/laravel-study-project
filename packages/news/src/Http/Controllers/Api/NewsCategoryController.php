<?php

namespace LaraN\News\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use LaraN\News\Http\Resources\NewsCategoryResource;
use LaraN\News\Models\NewsCategory;

class NewsCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = NewsCategory::query()
            ->orderBy('name')
            ->get();

        return NewsCategoryResource::collection($categories);
    }
}
