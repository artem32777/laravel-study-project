<x-layout title="Новости">
    <div class="-my-8 flex h-dvh flex-col py-8">
        <h1 class="mb-2 shrink-0 text-2xl">Новости</h1>

        <x-news::filter :categories="$categories"/>

        <x-news::list :news-list="$newsList"/>

        <div class="mt-8 shrink-0">
            {{ $newsList->links() }}
        </div>
    </div>
</x-layout>
