{{-- Nothing in the world is as soft and yielding as water. --}}

@php
    if (isset($event->truckersmp_event_data['response']['attendances'])) {
        $tmp_attendees = array_merge($event->truckersmp_event_data['response']['attendances']['confirmed_users'], $event->truckersmp_event_data['response']['attendances']['unsure_users']);
    }
@endphp

@section('title', $event->name)

@section('hero-title')
    <div class="space-y-2">
        <span class="flex">{{ $event->name }}</span>
        <span class="flex text-4xl">
            {{ $event->start_date->format('d M H:m') }}
        </span>
        <span class="flex text-2xl">
            Hosted by&nbsp;
            <span class="text-orange-600">
            @isset($event->truckersmp_event_vtc_data)
                    {{ $event->truckersmp_event_vtc_data['response']['name'] ?? 'Unknown VTC' }}
                @else
                    {{ ucfirst($event->host->username) ?? 'Unknown User' }}
                @endif
            </span>
        </span>
    </div>
@endsection

@section('hero-description')
    <div class="mt-3 space-y-2">
        @if($event->featured)
            <div class="flex space-x-2 text-sm font-medium text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <span>Featured</span>
            </div>
        @endif
        @if($event->external_event)
            <div class="flex space-x-2 text-sm font-medium text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>External Event</span>
            </div>
        @endif
        @if(!$event->public_event)
            <div class="flex space-x-2 text-sm font-medium text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span>Members Only</span>
            </div>
        @endif
        @auth
            @if($event->is_high_rewarding)
                <div class="flex space-x-2 text-sm font-bold text-orange-600">
                    <x-heroicon-o-sparkles class="h-5 w-5 text-white"/>
                    <span>High Rewarding Event</span>
                </div>
            @endif

            <div class="flex space-x-2 text-sm font-medium text-white">
                <span>
                    <strong>{{ $event->points }}</strong>
                    Event Points
                </span>
            </div>
        @endauth
    </div>
@endsection

@section('hero-image', $event->featured_image_url)

<div
    class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
    {{-- Main Column --}}
    <div class="space-y-6 lg:col-start-1 lg:col-span-2">
        {{-- Event Description --}}
        @if($event->description)
            <x-info-card title="Description">
                <div class="prose">
                    {!! $event->description !!}
                </div>
            </x-info-card>
        @endif

        @if($event->tmp_description)
            {{-- TruckersMP Event Description --}}
            <x-info-card title="TruckersMP Event Description">
                <div class="prose">
                    {!! $event->tmp_description !!}
                </div>
            </x-info-card>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="lg:col-start-3 lg:col-span-1 space-y-6">
        {{-- Event Information --}}
        <div class="rounded-lg overflow-hidden shadow">
            <x-info-card title="Event Information">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Game</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $event->game(false) ?? 'Unknown Game' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Server</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $event->server ?? 'Unknown Game' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Departure Location</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $event->departure_location }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Arrival Location</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $event->arrival_location }}</dd>
                    </div>
                    @isset($event->distance)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Distance</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $event->distance . ucwords($event->distance_metric) }}</dd>
                        </div>
                    @endisset
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Required DLCs</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $event->required_dlcs ?: 'None' }}</dd>
                    </div>
                </dl>
            </x-info-card>
        </div>

        {{-- Attending Options --}}
        @auth
            <div class="rounded-lg overflow-hidden shadow">
                <x-info-card title="Will you be attending?">
                    <div class="flex flex-col justify-stretch space-y-3">
                        <button type="button" wire:click="markAsAttending"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                            <x-heroicon-s-check-circle class="mr-1 h-5 w-5"/>
                            Yes
                        </button>
                        <button type="button" wire:click="markAsMaybeAttending"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400">
                            <x-heroicon-s-question-mark-circle class="mr-1 h-5 w-5"/>
                            Not sure
                        </button>
                        <button type="button" wire:click="markAsNotAttending"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
                            <x-heroicon-s-x-circle class="mr-1 h-5 w-5"/>
                            No
                        </button>

                        <x-alert/>
                    </div>
                </x-info-card>
            </div>
        @endauth

        {{-- Attendees --}}
        @if($event->attendees->count())
            <div class="rounded-lg overflow-hidden shadow">
                <x-info-card title="Attendees">
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @foreach($event->attendees->take(100) as $attendee)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="h-8 w-8 rounded-full"
                                                 src="{{ $attendee->user->profile_picture }}"
                                                 alt="{{ $attendee->user->username }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $attendee->user->username }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $attendee->updated_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div>
                                            @if($attendee->attending->value === App\Enums\Attending::Yes)
                                                <div
                                                    class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white">
                                                    Attending
                                                </div>
                                            @endif
                                            @if($attendee->attending->value === App\Enums\Attending::Maybe)
                                                <div
                                                    class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-gray-200">
                                                    Unsure
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @if($event->attendees->count() > 100)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            And {{ $event->attendees->count() - 100 }} more attendees
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </x-info-card>
            </div>
        @endif

        {{-- TruckersMP Attendees --}}
        @isset($event->truckersmp_event_data['response']['attendances'])
            <div class="rounded-lg overflow-hidden shadow">
                <x-info-card
                    title="TruckersMP Attendees ({{ count($tmp_attendees) }})">
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @foreach(array_slice($tmp_attendees, 0, 10) as $attendee)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="h-8 w-8 rounded-full"
                                                 src="https://eu.ui-avatars.com/api/?name={{ $attendee['username'] }}"
                                                 alt="{{ $attendee['username'] }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $attendee['username'] }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ Carbon\Carbon::parse($attendee['updated_at'])->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div>
                                            <div
                                                class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white">
                                                Attending
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @if(count($tmp_attendees) > 10)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            And {{ count($tmp_attendees) - 10 }} more attendees
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </x-info-card>
            </div>
        @endisset
    </div>
</div>
