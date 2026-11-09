<?php

declare(strict_types=1);

namespace LaraN\News\Dto;

class NewsDto
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $excerpt,
        public string $body,
        public int $authorId,
        public ?string $publishedAt,
        public array $categoryIds
    ) {}
}
