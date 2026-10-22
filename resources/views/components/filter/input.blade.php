@props([
    'name' => 'search',
    'label' => 'Поиск',
    'value' => null,
    'placeholder' => '',
    'type' => 'text'
])

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-2']) }}>
    <label for="{{ $name }}" class="text-sm text-gray-600">{{ $label }}</label>

    <input
        id="{{ $name }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
    >
</div>
