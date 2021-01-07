<section aria-labelledby="tmp-information-title" class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
    <h2 id="tmp-information-title" class="text-lg font-medium text-gray-900">TruckersMP Information</h2>
    <div class="mt-6 flow-root">
        <ul class="-mb-8">
            @if(!isset($application->ban_history['error'], $application->truckersmp_data['name']))
                {{-- TruckersMP Error --}}
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex space-x-3">
                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                <div>
                                    <p class="text-red-600">TruckersMP error while trying to fetch data</p>
                                    @isset($application->ban_history['error'])
                                        <p>
                                            Error: <strong>{{ $application->ban_history['descriptor'] }}</strong>
                                        </p>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @else

                {{-- Account Created At --}}
                <li>
                    <div class="relative pb-8">
                        @isset($application->ban_history['response'][0])
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                  aria-hidden="true"></span>
                        @endisset
                        <div class="relative flex space-x-3">
                            <div>
                                <span
                                    class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
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
                                    <p class="text-sm text-gray-500">Account created</p>
                                </div>
                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                    <time
                                        datetime="{{ \Carbon\Carbon::parse($application->truckersmp_data['joinDate'])->toDateString() }}">
                                        {{ \Carbon\Carbon::parse($application->truckersmp_data['joinDate'])->toFormattedDateString() }}
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- No Bans --}}
                @if($application->truckersmp_data['displayBans'] && $application->truckersmp_data['bansCount'] === 0)
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span
                                        class="h-8 w-8 rounded-full bg-green-400 flex items-center justify-center ring-8 ring-white">
                                        {{-- shield-check --}}
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">No bans</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @else
                    {{-- Ban History --}}
                    @foreach($application->ban_history['response'] as $ban)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                          aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                    <span
                                        class="h-8 w-8 rounded-full @if($ban['reason'] === '@BANBYMISTAKE') bg-blue-500 @else bg-red-500 @endif flex items-center justify-center ring-8 ring-white">
                                        {{-- ban --}}
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                Banned for {{ $ban['reason'] }}
                                                <br>
                                                <strong>Duration:</strong> {{ \Carbon\Carbon::parse($ban['timeAdded'])->diffInDays(\Carbon\Carbon::parse($ban['expiration'])) }}
                                                days
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time
                                                datetime="{{ \Carbon\Carbon::parse($ban['timeAdded'])->toDateString() }}">
                                                {{ \Carbon\Carbon::parse($ban['timeAdded'])->toFormattedDateString() }}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif

                {{-- Is TruckersMP Staff --}}
                @if($application->truckersmp_data['permissions']['isStaff'])
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span
                                        class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white">
                                        {{-- lightning-bolt --}}
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            TruckersMP {{ $application->truckersmp_data['groupName'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif

                {{-- Ban History Private --}}
                @if($application->truckersmp_data['displayBans'] === false)
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span
                                        class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                        {{-- exclamation --}}
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Ban history private</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif

                {{-- Currently Banned --}}
                @if($application->truckersmp_data['banned'])
                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span
                                        class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                        {{-- ban --}}
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Currently Banned</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif

            @endif
        </ul>
    </div>
    <div class="mt-6 flex flex-col justify-stretch space-y-2">
        <button type="button" wire:click="clearTMPData"
                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Refresh data
        </button>
        <p class="text-center text-xs text-gray-500">
            Refreshes once every 24 hours after opening the application
        </p>
    </div>
</section>
