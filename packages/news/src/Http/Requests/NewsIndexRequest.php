<?php

namespace LaraN\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class NewsIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'category' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'Поиск по заголовку не длиннее 255 символов.',
            'published_at.date' => 'Дата публикации должна быть датой.',
            'category.max' => 'Категория не длиннее 255 символов.',
        ];
    }

    public function title(): string
    {
        return $this->safe()->string('title')->trim()->toString();
    }

    public function category(): string
    {
        return $this->safe()->string('category')->trim()->toString();
    }

    public function publishedAt(): ?Carbon
    {
        return $this->safe()->date('published_at');
    }
}
