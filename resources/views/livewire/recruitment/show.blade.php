@section('title', "Viewing $application->username's application")

<main class="py-10">
    <x-alert/>

    {{-- Page header --}}
    <div
        class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
        <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
                <div class="relative">
                    <img class="h-16 w-16 rounded-full"
                         src="{{ $application->steam_data['avatarfull'] }}"
                         alt="">
                    <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $application->username }}</h1>
                <p class="text-sm font-medium text-gray-500">
                    Applied
                    <time
                        datetime="{{ \Carbon\Carbon::parse($application->created_at)->toDateString() }}">
                        {{ \Carbon\Carbon::parse($application->created_at)->diffForHumans() }}
                    </time>
                    <time
                        datetime="{{ \Carbon\Carbon::parse($application->created_at)->toDateString() }}">
                        ({{ \Carbon\Carbon::parse($application->created_at)->toDayDateTimeString() }})
                    </time>
                </p>
                @if($application->is_completed)
                    <p class="text-sm font-bold font-medium text-gray-500">
                        Completed
                        <time
                            datetime="{{ \Carbon\Carbon::parse($application->completed_at)->toDateString() }}">
                            {{ $application->time_until_completion }}
                        </time>
                        submission
                    </p>
                @endif
            </div>
        </div>
        @if(!$application->is_completed)
            <div
                class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                @if($application->claimed_by !== Auth::id())
                    <button type="button" wire:click="claim"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Claim
                    </button>
                @else
                    <button type="button" wire:click="unclaim"
                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Unclaim
                    </button>
                @endif
            </div>
        @endif
    </div>

    <div
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            {{-- Applicant Information --}}
            <section aria-labelledby="applicant-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="applicant-information-title" class="text-lg leading-6 font-medium text-gray-900">
                            Applicant Information
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Let's get personal.
                        </p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Steam Username
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if(empty($application->steam_data['personaname']) || empty($application->steam_data['steamID64']))
                                        Could not resolve Steam name
                                    @else
                                        <p class="mt-2 flex items-center">
                                            {{ $application->steam_data['personaname'] }}
                                            <a target="_blank"
                                               href="https://steamcommunity.com/profiles/{{ $application->steam_data['steamID64'] }}">
                                                <svg class="h-4 w-4 ml-1 text-orange-600"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        </p>
                                    @endif
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    TruckersMP Username
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if(empty($application->truckersmp_data['name']))
                                        Could not resolve TMP name
                                    @else
                                        <p class="mt-2 flex items-center">
                                            {{ $application->truckersmp_data['name'] }}
                                            <a target="_blank"
                                               href="https://truckersmp.com/user/{{ $application->truckersmp_data['id'] }}">
                                                <svg class="h-4 w-4 ml-1 text-orange-600"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        </p>
                                    @endif
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Base Username
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $application->username }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Email Address
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $application->email }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Date of Birth
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $application->date_of_birth }}
                                    <div class="flex items-center mt-0.5">
                                        @if($application->age < 16)
                                            {{-- exclamation --}}
                                            <svg class="h-5 w-5 text-orange-400" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        @else
                                            {{-- check-circle --}}
                                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                        <span class="text-gray-900 text-sm font-semibold ml-1">{{ $application->age }} years</span>
                                    </div>
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Country
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $application->country }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    {{-- <div>
                        <a href="#"
                           class="block bg-gray-50 text-sm font-medium text-gray-500 text-center px-4 py-4 hover:text-gray-700 sm:rounded-b-lg">
                            View past application
                        </a>
                    </div> --}}
                </div>
            </section>

            {{-- Digital Interview --}}
            <section aria-labelledby="digital-interview-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="digital-interview-title" class="text-lg leading-6 font-medium text-gray-900">
                            Digital Interview
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            What should this say?
                        </p>
                    </div>
                    <div class="border-t borfder-gray-200 px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            @foreach($application->application_answers as $question => $answer)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ $question }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if(is_numeric($answer))
                                            <div class="flex items-center mt-0.5">
                                                @if($answer === "0")
                                                    {{-- exclamation --}}
                                                    <svg class="h-5 w-5 text-orange-400"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    <span class="text-gray-900 text-sm ml-1">No</span>
                                                @else
                                                    {{-- check-circle --}}
                                                    <svg class="h-5 w-5 text-green-400"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-gray-900 text-sm ml-1">Yes</span>
                                                @endif
                                            </div>
                                        @else
                                            {{ ucfirst($answer) }}
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </section>

            @include('livewire.recruitment.components.staff-comments')
        </div>

        <div class="lg:col-start-3 lg:col-span-1 space-y-6">
            @include('livewire.recruitment.components.truckersmp-information')

            @include('livewire.recruitment.components.application-actions')
        </div>
    </div>
</main>
