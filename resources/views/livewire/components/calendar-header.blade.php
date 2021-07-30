<div class="flex items-center justify-between py-2 px-6 bg-gray-50">
    <div>
        <span class="text-lg font-bold text-gray-800">{{ $startsAt->monthName }}</span>
        <span class="ml-1 text-lg text-gray-600 font-normal">{{ $startsAt->year }}</span>
    </div>
    <div class="border rounded-lg px-1">
        <button wire:click="goToPreviousMonth"
                type="button"
                class="leading-none rounded-lg inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center">
            <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <div class="border-r inline-flex h-6"></div>
        <button wire:click="goToCurrentMonth"
                type="button"
                class="leading-none rounded-lg inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center">
            <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
            </svg>
        </button>
        <div class="border-r inline-flex h-6"></div>
        <button wire:click="goToNextMonth"
                type="button"
                class="leading-none rounded-lg inline-flex items-center cursor-pointer hover:bg-gray-200 p-1">
            <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
</div>
