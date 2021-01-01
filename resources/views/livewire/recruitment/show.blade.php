@section('title', "Viewing $application->username's application")

<main class="py-10">
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
            </div>
        </div>
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

                <button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                    Change status
                </button>
            @endif
        </div>
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
                                    {{ $application->steam_data['personaname'] }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    TruckersMP Username
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $application->truckersmp_data['name'] }}
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
                    <div>
                        <a href="#"
                           class="block bg-gray-50 text-sm font-medium text-gray-500 text-center px-4 py-4 hover:text-gray-700 sm:rounded-b-lg">
                            View past application
                        </a>
                    </div>
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
                                                @if($answer === 0)
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

            {{-- Staff Comments --}}
            <section aria-labelledby="staff-comments-title">
                <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 id="staff-comments-title" class="text-lg font-medium text-gray-900">
                                Staff Comments
                            </h2>
                        </div>
                        <div class="px-4 py-6 sm:px-6">
                            <ul class="space-y-8">
                                <li>
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full"
                                                 src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                 alt="">
                                        </div>
                                        <div>
                                            <div class="text-sm">
                                                <a href="#" class="font-medium text-gray-900">Leslie Alexander</a>
                                            </div>
                                            <div class="mt-1 text-sm text-gray-700">
                                                <p>Ducimus quas delectus ad maxime totam doloribus reiciendis ex.
                                                    Tempore dolorem maiores. Similique voluptatibus tempore non
                                                    ut.</p>
                                            </div>
                                            <div class="mt-2 text-sm space-x-2">
                                                <span class="text-gray-500 font-medium">4d ago</span>
                                                <span class="text-gray-500 font-medium">&middot;</span>
                                                <button type="button" class="text-gray-900 font-medium">Reply
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-6 sm:px-6">
                        <div class="flex space-x-3">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                     src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80"
                                     alt="">
                            </div>
                            <div class="min-w-0 flex-1">
                                <form action="#">
                                    <div>
                                        <label for="comment" class="sr-only">About</label>
                                        <textarea id="comment" name="comment" rows="3"
                                                  class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md"
                                                  placeholder="Add a note"></textarea>
                                    </div>
                                    <div class="mt-3 flex items-center justify-between">
                                        <a href="#"
                                           class="group inline-flex items-start text-sm space-x-2 text-gray-500 hover:text-gray-900">
                                            <!-- Heroicon name: question-mark-circle -->
                                            <svg
                                                class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            <span>
                                                    These comments are not visible to the user.
                                                </span>
                                        </a>
                                        <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Comment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('livewire.recruitment.components.truckersmp-information')
    </div>
</main>
