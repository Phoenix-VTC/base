@props([
    'error' => null,
])

<textarea
    {{ $attributes->merge(['class' => 'mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md' . ($error ? ' border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red' : '')]) }}>
</textarea>
