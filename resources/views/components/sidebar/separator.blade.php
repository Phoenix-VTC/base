@props([
    'title' => null
])

<div class="relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center">
        <div class="px-2 bg-gray-800 text-sm text-gray-400">
            {{ $title }}
        </div>
    </div>
</div>
