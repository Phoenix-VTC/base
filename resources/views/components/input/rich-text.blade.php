@props(['initialValue' => ''])

<div
    wire:ignore
    {{ $attributes->merge(['class' => 'rounded-md shadow-sm']) }}
    x-data
    @trix-blur="$dispatch('change', $event.target.value)"
>
    <input id="x" value="{{ $initialValue }}" type="hidden">
    <trix-editor input="x"
                 class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"></trix-editor>
</div>
