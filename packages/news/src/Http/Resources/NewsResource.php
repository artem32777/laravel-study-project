<?php

namespace LaraN\News\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraN\News\Models\NewsCategory;

class NewsResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'image' => $this->image,
            'published_at' => $this->published_at?->toIso8601String(),
            'author' => $this->whenLoaded('author', fn () => $this->author->name),

            'categories' => $this->whenLoaded(
                'categories',
                fn () => $this->categories->map(
                    fn (NewsCategory $category) => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ],
                ),
            ),
        ];
    }
}
