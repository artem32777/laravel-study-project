<x-layout title="Новости через API">
    <div class="-my-8 flex h-dvh flex-col py-8">
        <h1 class="mb-2 shrink-0 text-2xl">Новости через API</h1>

        <form id="news-filter" class="relative grid space-y-2 z-20 mb-4 shrink-0 flex-wrap items-center gap-2">
            <x-filter.input
                name="title"
                label="Поиск по заголовку"
                placeholder="Часть заголовка"
            />

            <x-filter.input
                name="published_at"
                type="date"
                label="Дата публикации"
            />

            <div class="flex flex-wrap items-center gap-2">
                <label for="news-category" class="text-sm text-gray-600">Категория</label>
                <select id="news-category" name="category"
                        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm">
                    <option value="">Все категории</option>
                </select>
            </div>

            <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-sm text-white">
                Показать
            </button>

            <button type="button" id="news-filter-reset"
                    class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm">
                Сбросить фильтры
            </button>
        </form>

        <div id="news-api" class="min-h-0 flex-1 space-y-6 pr-4 overflow-y-auto"></div>

        <div id="news-pagination" class="mt-8 shrink-0"></div>
    </div>

    <script>
        const root = document.querySelector('#news-api');
        const pagination = document.querySelector('#news-pagination');
        const form = document.querySelector('#news-filter');
        const categorySelect = document.querySelector('#news-category');

        function loadCategories() {
            fetch('/api/v1/news-categories')
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('request failed');
                    }

                    return response.json();
                })
                .then((payload) => {
                    for (const category of payload.data) {
                        const option = document.createElement('option');
                        option.value = category.slug;
                        option.textContent = category.name;
                        categorySelect.append(option);
                    }
                });
        }

        function filtersFromForm() {
            const formData = new FormData(form);

            return {
                title: String(formData.get('title') ?? '').trim(),
                published_at: String(formData.get('published_at') ?? '').trim(),
                category: String(formData.get('category') ?? '').trim(),
            };
        }

        function pageButton(text, page, filters, disabled, active = false) {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = text;
            button.disabled = disabled;
            button.className = active
                ? 'rounded-md bg-gray-900 px-3 py-2 text-sm text-white'
                : 'rounded-md border border-gray-300 bg-white px-3 py-2 text-sm disabled:cursor-not-allowed disabled:text-gray-400';

            if (!disabled) {
                button.addEventListener('click', () => {
                    loadNews(filters, page);
                });
            }

            return button;
        }

        function renderPagination(meta, filters) {
            pagination.replaceChildren();

            if (meta.last_page <= 1) {
                return;
            }

            const nav = document.createElement('nav');
            nav.className = 'flex flex-wrap gap-2';

            nav.append(pageButton('Назад', meta.current_page - 1, filters, meta.current_page <= 1));

            for (let page = 1; page <= meta.last_page; page += 1) {
                nav.append(pageButton(String(page), page, filters, page === meta.current_page, page === meta.current_page));
            }

            nav.append(pageButton('Вперёд', meta.current_page + 1, filters, meta.current_page >= meta.last_page));

            pagination.append(nav);
        }

        function loadNews(filters, page = 1) {
            root.replaceChildren();
            pagination.replaceChildren();

            const url = new URL('/api/v1/news', window.location.origin);

            if (filters.title !== '') {
                url.searchParams.set('title', filters.title);
            }

            if (filters.published_at !== '') {
                url.searchParams.set('published_at', filters.published_at);
            }

            if (filters.category !== '') {
                url.searchParams.set('category', filters.category);
            }

            if (page > 1) {
                url.searchParams.set('page', String(page));
            }

            fetch(url)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('request failed');
                    }

                    return response.json();
                })
                .then((payload) => {
                    const news = payload.data;

                    if (news.length === 0) {
                        const empty = document.createElement('p');
                        empty.textContent = 'Новостей пока нет.';
                        root.append(empty);

                        return;
                    }

                    for (const item of news) {
                        const link = document.createElement('a');
                        link.href = `/news/${item.slug}`;
                        link.className = 'block rounded-lg bg-white p-6 shadow-sm hover:bg-blue-50';

                        const title = document.createElement('h2');
                        title.className = 'text-xl font-semibold';
                        title.textContent = item.title;

                        const meta = document.createElement('p');
                        meta.className = 'mt-1 text-sm text-gray-500';
                        const date = new Date(item.published_at).toLocaleDateString('ru-RU');
                        const categories = item.categories.map((category) => category.name).join(', ');
                        meta.textContent = `${date} · ${categories} · ${item.author}`;

                        const excerpt = document.createElement('p');
                        excerpt.className = 'mt-3';
                        excerpt.textContent = item.excerpt ?? '';

                        link.append(title, meta, excerpt);
                        root.append(link);
                    }

                    renderPagination(payload.meta, filters);
                })
                .catch(() => {
                    const error = document.createElement('p');
                    error.textContent = 'Не удалось загрузить новости.';
                    root.append(error);
                });
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            loadNews(filtersFromForm(), 1);
        });

        loadCategories();
        loadNews({title: '', published_at: '', category: ''}, 1);

        document.querySelector('#news-filter-reset').addEventListener('click', () => {
            form.reset();

            loadNews(filtersFromForm(), 1);
        });
    </script>
</x-layout>
