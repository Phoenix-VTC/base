<div class="md:hidden" x-show="sidebarOpen">
    <div class="fixed inset-0 flex z-40">
        <div class="fixed inset-0" aria-hidden="true" x-show="sidebarOpen" x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800" x-show="sidebarOpen" x-cloak
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button
                    class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    {{-- x --}}
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex-shrink-0 flex items-center px-4">
                <img class="h-12 w-12 w-auto"
                     src="{{ asset('img/logo.png') }}" height="48" width="48" alt="Phoenix">
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto" @click.away="sidebarOpen = false">
                <nav class="px-2 space-y-1">
                    @include('includes.navigation-items')
                </nav>
            </div>
        </div>

    </div>
</div>

<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col h-0 flex-1">
            <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                <img class="h-14 w-auto"
                     src="{{ asset('img/logo.png') }}" height="56" width="56" alt="Phoenix">
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">
                    @include('includes.navigation-items')
                </nav>
            </div>
        </div>
    </div>
</div>

