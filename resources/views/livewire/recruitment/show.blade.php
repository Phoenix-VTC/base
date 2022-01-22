@section('title', "Viewing $application->username's application")

<div>
    <x-alert/>

    {{-- Page header --}}
    <div
        class="max-w-3xl px-4 mx-auto sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
        <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
                <div class="relative">
                    <img class="w-16 h-16 rounded-full"
                         src="{{ $application->steam_data['avatarfull'] }}"
                         alt="">
                    <span class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></span>
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
                    <p class="text-sm font-medium font-bold text-gray-500">
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
                class="flex flex-col-reverse mt-6 space-y-4 space-y-reverse justify-stretch sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                @if($application->claimed_by !== Auth::id())
                    <button type="button" wire:click="claim"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Claim
                    </button>
                @else
                    <button type="button" wire:click="unclaim"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Unclaim
                    </button>
                @endif
            </div>
        @endif
    </div>

    <div
        class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            {{-- Applicant Information --}}
            <section aria-labelledby="applicant-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">
                            Applicant Information
                        </h2>
                        <p class="max-w-2xl mt-1 text-sm text-gray-500">
                            Let's get personal.
                        </p>
                    </div>
                    <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Steam Username
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if(empty($application->steam_data['personaname']) || empty($application->steam_data['steamID64']))
                                        Could not resolve Steam name
                                    @else
                                        <p class="flex items-center mt-2">
                                            {{ $application->steam_data['personaname'] }}
                                            <a target="_blank"
                                               href="https://steamcommunity.com/profiles/{{ $application->steam_data['steamID64'] }}">
                                                <svg class="w-4 h-4 ml-1 text-orange-600"
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
                                        <p class="flex items-center mt-2">
                                            {{ $application->truckersmp_data['name'] }}
                                            <a target="_blank"
                                               href="https://truckersmp.com/user/{{ $application->truckersmp_data['id'] }}">
                                                <svg class="w-4 h-4 ml-1 text-orange-600"
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
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Discord Username
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if(empty($application->discord_username))
                                        Unknown Discord Username
                                    @else
                                        <p class="flex items-center mt-2">
                                            {{ $application->discord_username }}
                                        </p>
                                    @endif
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
                                            <svg class="w-5 h-5 text-orange-400" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        @else
                                            {{-- check-circle --}}
                                            <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                        <span class="ml-1 text-sm font-semibold text-gray-900">{{ $application->age }} years</span>
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
                </div>
            </section>

            {{-- Digital Interview --}}
            <section aria-labelledby="digital-interview-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="digital-interview-title" class="text-lg font-medium leading-6 text-gray-900">
                            Digital Interview
                        </h2>
                        <p class="max-w-2xl mt-1 text-sm text-gray-500">
                            What should this say?
                        </p>
                    </div>
                    <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
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
                                                    <svg class="w-5 h-5 text-orange-400"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    <span class="ml-1 text-sm text-gray-900">No</span>
                                                @else
                                                    {{-- check-circle --}}
                                                    <svg class="w-5 h-5 text-green-400"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="ml-1 text-sm text-gray-900">Yes</span>
                                                @endif
                                            </div>
                                        @else
                                            {{-- First ucword every newline --}}
                                            {{-- Then escape any code in the var with e: https://laravel.com/docs/8.x/helpers#method-e --}}
                                            {{-- Then convert newlines to <br>s with nl2br --}}
                                            {{-- Then display that data unescaped (it's safe because of the 2nd comment) --}}
                                            <div class="prose-sm prose">
                                                <blockquote>{!! nl2br(e(ucwords($answer, "\n"))) !!}</blockquote>
                                            </div>
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </section>

            <section aria-labelledby="previous-applications-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="previous-applications-title" class="text-lg font-medium leading-6 text-gray-900">
                            <b>{{ $previousApplications->count() }}</b>
                            Previous Driver {{ Str::plural('Application', $previousApplications->count()) }}
                        </h2>
                        <p class="max-w-2xl mt-1 text-sm text-gray-500">
                            Searched with the applicant's username, email, Discord username, TruckersMP ID and Steam ID.
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        @if($previousApplications->count() > 0)
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                        <div class="overflow-hidden sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                        Username
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                        Email
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                        Date
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                        Outcome
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3">
                                                        <span class="sr-only">View</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($previousApplications as $previousApplication)
                                                    <tr class="bg-white @if($loop->odd) bg-white @else bg-gray-50 @endif">
                                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                            {{ $previousApplication->username }}
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            {{ $previousApplication->email }}
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            <time
                                                                datetime="{{ \Carbon\Carbon::parse($previousApplication->created_at)->toDateString() }}">
                                                                {{ \Carbon\Carbon::parse($previousApplication->created_at)->toDayDateTimeString() }}
                                                            </time>
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            {{ ucwords(str_replace('_', ' ', $previousApplication->status)) }}
                                                        </td>
                                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                            <a href="{{ route('recruitment.show', $previousApplication->uuid) }}"
                                                               class="text-indigo-600 hover:text-indigo-900">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <x-heroicon-o-shield-check class="w-12 h-12 mx-auto text-gray-400"/>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No previous applications</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    We couldn't find any related previous applications.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            @include('livewire.recruitment.components.staff-comments')

            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">
                        Revision history
                    </h3>
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    User ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Field Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Old Value
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    New Value
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Date
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($application->revisionHistoryWithUser as $revision)
                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                    <td class="px-6 py-4 text-sm prose-sm prose text-gray-900 whitespace-nowrap">
                                        @if($revision->user)
                                            <a href="{{ route('users.profile', $revision->user) }}">
                                                {{ $revision->user->username ?? 'Deleted User' }}
                                            </a>
                                        @else
                                            <span class="font-semibold">System</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $revision->fieldName() ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $revision->oldValue() ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $revision->newValue() ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $revision->created_at }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        There is no revision history available yet for this application.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 lg:col-start-3 lg:col-span-1">
            @include('livewire.recruitment.components.truckersmp-information')

            @include('livewire.recruitment.components.application-actions')
        </div>
    </div>
</div>
