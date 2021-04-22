{{-- The Master doesn't talk, he acts. --}}

<div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
    <dt>
        <div class="absolute bg-orange-500 rounded-md p-3">
            @svg('heroicon-' . $icon, ['class' => 'h-6 w-6 text-white'])
        </div>
        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
            {{ $title }}
        </p>
    </dt>
    <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900">
            {{ $content }}
        </p>
        <div class="ml-2 flex items-baseline text-sm font-semibold">
            <div class="self-center flex-shrink-0 h-4 w-4">
                @if($increased)
                    <x-heroicon-s-arrow-up class="text-green-500"/>
                @else
                    <x-heroicon-s-arrow-down class="text-red-500"/>
                @endif
            </div>

            <span class="sr-only">
                {{ $increased ? 'Increased' : 'Decreased' }} by
            </span>
            <span class="{{ $increased ? 'text-green-600' : 'text-red-600' }}">
                {{ $changeNumber }}
            </span>
        </div>
        <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
                <a href="#" class="font-medium text-orange-600 hover:text-orange-500">
                    View all
                </a>
            </div>
        </div>
    </dd>
</div>
