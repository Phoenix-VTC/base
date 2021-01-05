@section('title', 'Driver Applications')

<div class="bg-white shadow overflow-hidden sm:rounded-md mt-5">
    <ul class="divide-y divide-gray-200">
        @foreach($applications as $application)
            <li>
                <a href="{{ route('recruitment.show', ['uuid' => $application->uuid]) }}"
                   class="block border-b-2 @if(!$application->claimed_by) hover:bg-gray-50 @else bg-gray-300 hover:bg-gray-200 @endif">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full"
                                     src="{{ $application->steam_data['avatarfull'] }}"
                                     alt="">
                            </div>
                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <p class="text-sm font-medium text-grey-600 truncate">{{ $application->username }}</p>
                                    <p class="flex items-center text-sm mt-2 text-gray-500">
                                        {{-- at-symbol --}}
                                        <svg class="flex-shrink-0 mr-0.5 h-3.5 w-3.5 text-gray-400"
                                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>

                                        <span>{{ $application->truckersmp_data['name'] }} / {{ $application->steam_data['personaname'] }}</span>
                                    </p>
                                </div>
                                <div class="hidden md:block">
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            Applied
                                            <time
                                                datetime="{{ \Carbon\Carbon::parse($application->created_at)->toDateString() }}">
                                                {{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}
                                            </time>
                                        </p>
                                        <p class="mt-2 flex items-center text-sm">
                                            @if(!$application->claimed_by)
                                                {{-- exclamation-circle --}}
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-orange-400"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-orange-400">
                                                        Unclaimed
                                                    </span>
                                            @else
                                                @switch($application->status)
                                                    @case('pending')
                                                    {{-- clock --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-orange-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-orange-400">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    @break
                                                    @case('awaiting_response')
                                                    {{-- chat --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-indigo-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                    </svg>
                                                    <span class="text-indigo-400">
                                                            {{ ucwords(str_replace("_", " ", $application->status)) }}
                                                        </span>
                                                    @break
                                                    @case('investigation')
                                                    {{-- document-search --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-purple-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"/>
                                                    </svg>
                                                    <span class="text-purple-400">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    @break
                                                    @case('incomplete')
                                                    {{-- document --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-yellow-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-yellow-400">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    @break
                                                    @case('accepted')
                                                    {{-- check-circle --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-green-400">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    @break
                                                    @case('denied')
                                                    {{-- ban --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-red-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    </svg>
                                                    <span class="text-red-500">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    @break
                                                    @default
                                                    {{-- question-mark-circle --}}
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Unknown ({{ ucfirst($application->status) }})
                                                @endswitch
                                                <span class="text-xs ml-2">
                                                        ({{ $application->owner->username }})
                                                    </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <!-- Heroicon name: chevron-right -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

    {{ $applications->links() }}

    @empty($applications->count())
        <div class="bg-white overflow-hidden shadow rounded-lg text-center">
            <div class="px-4 py-5 sm:px-6 flex">
                <img class="mx-auto" width="45%" src="{{ asset('img/illustrations/team_spirit.svg') }}"
                     alt="Team spirit illustration"/>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <h1 class="text-4xl font-semibold text-gray-900">
                    This is where you'll see the driver applications.
                </h1>
            </div>
        </div>
    @endempty
</div>
