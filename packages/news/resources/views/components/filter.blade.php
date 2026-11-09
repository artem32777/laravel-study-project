@props([
    'categories',
])

<form
    method="GET"
    action="{{ route('news.index') }}"
    class="relative grid space-y-2 z-20 mb-4 shrink-0 flex-wrap items-center gap-2"
>
    @if ($errors->any())
        <div class="rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-filter.input
        name="title"
        label="Поиск по заголовку"
        placeholder="Часть заголовка"
        :value="old('title', request('title'))"
    />

    <x-filter.input
        name="published_at"
        type="date"
        label="Дата публикации"
        :value="old('published_at', request('published_at'))"
    />

    <x-filter.select
        name="category"
        label="Категория"
        :options="$categories"
        option-value="slug"
        option-label="name"
        placeholder="Все категории"
        :selected="old('category', request('category'))"
    />

    <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-sm text-white">
        Показать
    </button>

    <a href="{{ route('news.index') }}" class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm">
        Сбросить фильтры
    </a>
</form>
