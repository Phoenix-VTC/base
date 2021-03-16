@props([
    'id',
    'label',
    'error' => null,
])

<div class="flex items-center">
    <input type="radio" id="{{ $id }}" {{ $attributes->merge(['class' => 'focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300']) }} />

    <label for="{{ $id }}" class="ml-3 block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
</div>
