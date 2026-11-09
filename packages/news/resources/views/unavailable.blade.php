<x-layout title="Новость не найдена">
    <h1 class="text-2xl">Новость не найдена.</h1>

    <p class="mt-2 text-gray-600">Этой публикации нет в открытом списке.</p>

    <a href="{{ route('news.index') }}" class="mt-4 inline-block text-sm underline">
        К списку новостей
    </a>
</x-layout>
