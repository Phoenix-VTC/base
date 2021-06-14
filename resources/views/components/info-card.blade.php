<!-- No surplus words or unnecessary actions. - Marcus Aurelius -->

@props([
    'title' => null,
    'description' => null,
    'footer' => null
])

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ $title }}
        </h3>
        @if($description)
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $description }}
            </p>
        @endif
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
        {{ $slot }}
    </div>
    @if($footer)
        <div class="bg-gray-50 px-4 py-6 sm:px-6">
            {{ $footer }}
        </div>
    @endif
</div>
