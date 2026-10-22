<x-layout>
    <h1 class="text-5xl mb-10">Страницы:</h1>
    <ol class="list-disc">
        <li><a href="{{ route('news.index') }}" class="text-3xl">Новости (Blade)</a></li>
        <li><a href="{{ route('news.client') }}" class="text-3xl">Новости (Api)</a></li>
    </ol>
</x-layout>

