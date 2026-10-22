<?php

namespace LaraN\News\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use LaraN\News\Database\Factories\NewsCategoryFactory;
use Orchid\Screen\AsSource;

#[Fillable(['name', 'slug'])]
#[UseFactory(NewsCategoryFactory::class)]
class NewsCategory extends Model
{
    use AsSource;

    /** @use HasFactory<NewsCategoryFactory> */
    use HasFactory;

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
