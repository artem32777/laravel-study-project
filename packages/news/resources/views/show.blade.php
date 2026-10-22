<x-layout :title="$news->title">
    <h1 class="text-5xl font-bold">{{ $news->title }}</h1>

    <p class="mt-2 text-sm text-gray-500">
        {{ $news->published_at->format('d.m.Y H:i') }}
        · {{ $news->categories->pluck('name')->join(', ') }}
        · {{ $news->author->name }}
    </p>

    <div class="mt-6">{!! nl2br(e($news->body)) !!}</div>

    <a href="{{ route('news.index') }}" class="mt-8 inline-block">← Все новости</a>
</x-layout>
