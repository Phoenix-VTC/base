@props([
    'title' => null
])

<div class="relative py-5">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center">
        <span class="px-2 bg-gray-100 text-gray-500">
            {{ $title }}
        </span>
    </div>
</div>
