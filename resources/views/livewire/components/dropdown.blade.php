{{-- Do your work, then step back. --}}

<div x-data="{ showDropdown: @entangle('showDropdown') }">
    <a @click="showDropdown = !showDropdown"
       :class="showDropdown ? 'bg-gray-900 text-white rounded-t-md' : 'text-gray-300 hover:bg-gray-700 hover:text-white rounded-md'"
       class="w-full flex justify-between items-center px-2 py-2 text-sm font-medium cursor-pointer">
        <span
            :class="showDropdown ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300'"
            class="mr-3 h-6 w-6">
            @svg('heroicon-' . $icon)
        </span>

        <span class="flex-1">
            {{ $title }}
        </span>

        @if($unreadCount > 0)
            <span :class="showDropdown ? 'bg-gray-800' : 'bg-gray-900 group-hover:bg-gray-800'"
                   class="ml-3 inline-block py-0.5 px-3 text-xs font-medium rounded-full">
                {{ $unreadCount }}
            </span>
        @endif

        <div
            :class="showDropdown ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300'"
            class="ml-3 h-6 w-6">
            <x-heroicon-s-chevron-right x-show="!showDropdown" x-cloak/>
            <x-heroicon-s-chevron-down x-show="showDropdown"/>
        </div>
    </a>

    <div class="bg-gray-900 rounded-b-md" x-show="showDropdown" @if(!$showDropdown) x-cloak @endif>
        @foreach($items as $item)
            <a class="py-2 px-12 block text-sm text-gray-100 hover:bg-gray-700 hover:text-white @if($loop->last) rounded-b-md @endif"
               href="{{ route($item['route'], $item['parameters'] ?? null) }}">
                {{ $item['title'] }}
            </a>
        @endforeach
    </div>
</div>
