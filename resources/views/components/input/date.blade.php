@once
    @push('scripts')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
@endonce

@props([
    'error' => null,
    'options' => [],
    'leadingIcon' => null,
    'trailingIcon' => null,
])

@php
    $options = array_merge([
        'dateFormat' => 'Y-m-d\TH:i',
        'time_24hr' => true,
        'enableTime' => true,
        'altFormat' =>  'd/m/Y H:i',
        'altInput' => true,
        'minDate' => now(),
        ], $options);
@endphp

<div class="relative" wire:ignore>
    @if($leadingIcon)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            @svg('heroicon-' . $leadingIcon, ['class' => 'h-5 w-5 text-gray-400'])
        </div>
    @endif

    <input
        x-data="{value: @entangle($attributes->wire('model')), instance: undefined}"
        x-init="() => {
                $watch('value', value => instance.setDate(value, true));
                instance = flatpickr($refs.input, {{ json_encode((object)$options, JSON_THROW_ON_ERROR) }});
            }"
        x-ref="input"
        x-bind:value="value"
        type="text"
        placeholder="Please choose a date @if($options['enableTime'])and time @endif"
        {{ $attributes->merge(['class' => 'mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md' . ($error ? ' border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red' : '') . ($leadingIcon ? ' block pl-10' : '') . ($trailingIcon ? ' block pr-10' : '')]) }}
    />

    @if($trailingIcon)
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            @svg('heroicon-' . $trailingIcon, ['class' => 'h-5 w-5 text-gray-400'])
        </div>
    @endif
</div>
