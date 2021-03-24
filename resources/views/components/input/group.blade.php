@props([
    'label',
    'for',
    'error' => false,
    'helpText' => false,
    'colSpan' => 4
])

<div {{ $attributes->merge(['class' => 'col-span-6 sm:col-span-' . $colSpan]) }}>
    <label @isset($for) for="{{ $for }}" @endisset class="block text-sm font-medium text-gray-700">{{ $label }}</label>

    {{ $slot }}

    @if($error)
        <p class="mt-2 text-sm text-red-600 mb-0">{{ $error }}</p>
    @endif

    @if($helpText)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div>
