<!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->

@props([
    'title',
    'icon' => null,
    'width' => 'w-56',
    'notificationDotColor' => null,
])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <div @if($notificationDotColor) class="inline-block relative" @endif>
        <button type="button"
                class="@if($icon) bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 @else inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:ring-offset-gray-100 @endif focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                id="menu-button" aria-expanded="true" aria-haspopup="true" @click="open = !open">
            @if($icon)
                <span class="sr-only">{{ $title }}</span>
                @svg('heroicon-' . $icon, ['class' => 'h-6 w-6'])
            @else
                {{ $title }}
                <x-heroicon-s-chevron-down class="-mr-1 ml-2 h-5 w-5"/>
            @endif
        </button>
        @if($notificationDotColor)
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white {{ $notificationDotColor }}"></span>
        @endif
    </div>

    <div x-show="open" x-cloak
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="origin-top-right absolute z-10 right-0 mt-2 {{ $width }} rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
            {{ $slot }}
        </div>
    </div>
</div>
