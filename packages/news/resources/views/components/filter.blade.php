@props([
    'categories',
])

<form
    method="GET"
    action="{{ route('news.index') }}"
    class="relative grid space-y-2 z-20 mb-4 shrink-0 flex-wrap items-center gap-2"
>
    <x-filter.input
        name="title"
        label="Поиск по заголовку"
        placeholder="Часть заголовка"
        :value="request('title')"
    />

    <x-filter.input
        name="published_at"
        type="date"
        label="Дата публикации"
        :value="request('published_at')"
    />

    <x-filter.select
        name="category"
        label="Категория"
        :options="$categories"
        option-value="slug"
        option-label="name"
        placeholder="Все категории"
        :selected="request('category')"
    />

    <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-sm text-white">
        Показать
    </button>

    <a href="{{ route('news.index') }}" class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm">
        Сбросить фильтры
    </a>
</form>
