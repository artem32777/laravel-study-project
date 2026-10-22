@props([
    'newsList',
])

<div class="min-h-0 flex-1 space-y-6 pr-4 overflow-y-auto">
    @forelse ($newsList as $news)
        <a href="{{ route('news.show', $news) }}"
           class="rounded-lg block bg-white p-6 shadow-sm hover:bg-blue-50">
            <h2 class="text-xl font-semibold">{{ $news->title }}</h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ $news->published_at->format('d.m.Y') }}
                · {{ $news->categories->pluck('name')->join(', ') }}
                · {{ $news->author->name }}
            </p>

            <p class="mt-3">{{ $news->excerpt }}</p>
        </a>
    @empty
        <p>Новостей пока нет.</p>
    @endforelse
</div>
