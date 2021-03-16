@props([
    'legend',
    'error' => false,
])

<fieldset class="col-span-6 sm:col-span-4">
    <div>
        <legend class="block text-sm font-medium text-gray-700">
            {{ $legend }}
        </legend>
    </div>

    <div class="mt-4 space-y-4">
        {{ $slot }}

        @if($error)
            <p class="mt-2 text-sm text-red-600 mb-0">{{ $error }}</p>
        @endif
    </div>
</fieldset>
