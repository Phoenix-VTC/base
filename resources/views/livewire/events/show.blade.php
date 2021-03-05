{{-- Nothing in the world is as soft and yielding as water. --}}

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
                    {{ $event->host->username ?? 'Unknown User' }}
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
    </div>
@endsection

@section('hero-image', $event->featured_image_url)

<div>
    <div class="mt-10 max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8 gap-1">
            {{-- Event Description --}}
            @if($event->description)
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <x-info-card title="Description">
                        <div class="prose lg:prose-lg">
                            {!! $event->description !!}
                        </div>
                    </x-info-card>
                </div>
            @endif

            {{-- Event Information --}}
            <div class="grid grid-cols-1 gap-4">
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
            </div>

            {{-- TruckersMP Event Description --}}
            <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                <x-info-card title="TruckersMP Event Description">
                    <div class="prose lg:prose-lg">
                        {!! $event->tmp_description !!}
                    </div>
                </x-info-card>
            </div>
        </div>
    </div>
</div>
