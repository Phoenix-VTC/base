<section class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
    <h2 id="tmp-information-title" class="text-lg font-medium text-gray-900">Application Information</h2>
    <div class="mt-6 flow-root">
        <ul class="-mb-8">
            {{-- Claimed By --}}
            <li>
                <div class="relative pb-8">
                    <div class="relative flex space-x-3">
                        <div>
                            <span
                                class="h-8 w-8 rounded-full @if($application->claimed_by) bg-blue-500 @else bg-gray-400 @endif flex items-center justify-center ring-8 ring-white">
                                {{-- user --}}
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    @if($application->claimed_by)
                                        Claimed by <strong>{{ $application->owner->username }}</strong>
                                    @else
                                        Unclaimed
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            {{-- Status --}}
            <li>
                <div class="relative pb-8">
                    <div class="relative flex space-x-3">
                        <div>
                            <span
                                class="h-8 w-8 rounded-full bg-indigo-400 flex items-center justify-center ring-8 ring-white">
                                {{-- collection --}}
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Status:
                                    <strong>
                                        @if(!$application->claimed_by)
                                            Unclaimed
                                        @else
                                            {{ ucwords(str_replace("_", " ", $application->status)) }}
                                        @endif
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    @if($application->claimed_by)
        @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4 mt-4">
                <div class="flex">
                    <div>
                        <h3 class="text-sm font-medium text-red-800">
                            There were {{ $errors->count() }} errors while trying to accept the application:
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(!$application->is_completed)
            <div class="mt-6 flex flex-col justify-stretch space-y-3">
                <button type="button" wire:click="accept"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                    Accept
                </button>

                <div x-data="{ open: false }" @keydown.escape="open = false" @click.away="open = false"
                     class="relative inline-block text-left">
                    <div>
                        <button type="button" @click="open = !open"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                                id="options-menu" aria-haspopup="true" aria-expanded="true">
                            Other options
                            {{-- chevron-down --}}
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100"
                         role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <div class="py-1">
                            <a href="#" wire:click="setStatus('pending')"
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">
                                {{-- clock --}}
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pending
                            </a>
                            <a href="#" wire:click="setStatus('incomplete')"
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">
                                {{-- document --}}
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Incomplete
                            </a>
                            <a href="#" wire:click="setStatus('awaiting_response')"
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">
                                {{-- chat --}}
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Awaiting Response
                            </a>
                            <a href="#" wire:click="setStatus('investigation')"
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">
                                {{-- document-search --}}
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"/>
                                </svg>
                                Investigation
                            </a>
                        </div>
                        <div class="py-1">
                            <a href="#" wire:click="deny"
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">
                                {{-- ban --}}
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Deny
                            </a>
                        </div>
                        {{-- <div class="py-1">
                            <a href="#" wire:click="blacklist"
                               class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                               role="menuitem">
                                shield-exclamation
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/>
                                </svg>
                                Blacklist
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endif
    @endif
</section>
