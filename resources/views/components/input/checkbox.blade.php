@props([
    'id',
    'label',
    'error' => null,
    'helpText' => false,
])

<div class="flex items-start">
    <div class="h-5 flex items-center">
        <input type="checkbox"
               id="{{ $id }}" {{ $attributes->merge(['class' => 'focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded']) }} />
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $id }}" class="font-medium text-gray-700">{{ $label }}</label>

        @if($helpText)
            <p class="text-gray-500">{{ $helpText }}</p>
        @endif

        @if($error)
            <p class="mt-2 text-sm text-red-600 mb-0">{{ $error }}</p>
        @endif
    </div>
</div>
