@props([
    'name',
    'multiple' => false,
    'label',
    'options',
    'optionValue',
    'optionLabel',
    'selected' => null,
    'placeholder' => 'Все',
])

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-2']) }}>
    <label for="{{ $name }}" class="text-sm text-gray-600">{{ $label }}</label>

    <select
        id="{{ $name }}"
        name="{{ $multiple ? $name.'[]' : $name }}"
        @if ($multiple) multiple @endif
        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
    >
        @unless ($multiple)
            <option value="" @selected(blank($selected))>{{ $placeholder }}</option>
        @endunless

        @foreach ($options as $option)
            <option
                value="{{ data_get($option, $optionValue) }}"
                @selected(
                    $multiple
                        ? collect($selected)->contains(fn ($item) => (string) $item === (string) data_get($option, $optionValue))
                        : (string) data_get($option, $optionValue) === (string) $selected
                )
            >
                {{ data_get($option, $optionLabel) }}
            </option>
        @endforeach
    </select>
</div>
