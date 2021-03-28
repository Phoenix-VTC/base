<div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
    <div class="flex-shrink-0">
        <a href="{{ route('events.show', ['id' => $event->id, 'slug' => $event->slug]) }}">
            <img class="h-48 w-full object-cover object-left"
                 src="{{ $event->featured_image_url }}"
                 alt="{{ $event->name }}">
        </a>
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
        <div class="flex-1 space-y-2">
            @if($event->featured)
                <div class="flex space-x-2 text-sm font-medium text-orange-600">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <span>Featured</span>
                </div>
            @endif
            <a href="{{ route('events.show', ['id' => $event->id, 'slug' => $event->slug]) }}" class="block mt-2">
                <p class="text-xl font-semibold text-gray-900">
                    {{ $event->name }}
                </p>
                <div class="text-base text-gray-500 prose-sm">
                    {!! Str::words(strip_tags($event->description), 15) !!}
                </div>
            </a>
        </div>
        <div class="mt-3 space-y-2">
            @if($event->external_event)
                <div class="flex space-x-2 text-sm font-medium text-orange-600">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>External Event</span>
                </div>
            @endif
            <div class="flex space-x-2 text-sm font-medium text-gray-900">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ $event->start_date->format('d M H:i') }} UTC</span>
            </div>
            @if(!$event->public_event)
                <div class="flex space-x-2 text-sm font-medium text-gray-900">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Members Only</span>
                </div>
            @endif
            @auth
                <div class="flex space-x-2 text-sm font-medium text-gray-900">
                    <x-heroicon-o-star class="h-5 w-5"/>
                    <span>
                        <strong>{{ $event->points }}</strong>
                        Event XP
                    </span>
                </div>

                @if($event->is_high_rewarding)
                    <div class="flex space-x-2 text-sm font-bold text-red-600">
                        <x-heroicon-o-sparkles class="h-5 w-5"/>
                        <span>High Rewarding Event</span>
                    </div>
                @endif
            @endauth
        </div>
        @isset($event->truckersmp_event_vtc_data)
            <div class="mt-6 flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                         src="{{ $event->truckersmp_event_vtc_data['response']['logo'] ?? '' }}"
                         alt="{{ $event->truckersmp_event_vtc_data['response']['name'] ?? 'Unknown VTC' }}">
                </div>
                <div class="ml-3">
                    <div class="flex space-x-1 text-sm text-gray-500">
                        <span>Hosted By</span>
                    </div>
                    <p class="text-sm font-medium capitalize text-gray-900">
                        <a href="https://truckersmp.com{{ $event->truckersmp_event_data['response']['url'] ?? '#' }}"
                           target="_blank">
                            {{ $event->truckersmp_event_vtc_data['response']['name'] ?? 'Unknown VTC' }}
                        </a>
                    </p>
                </div>
            </div>
        @else
            <div class="mt-6 flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('events.show', ['id' => $event->id, 'slug' => $event->slug]) }}">
                        <img class="h-10 w-10 rounded-full"
                             src="{{ $event->host->profile_picture ?? '' }}"
                             alt="{{ $event->host->username ?? 'Unknown User' }}">
                    </a>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium capitalize text-gray-900">
                        {{ $event->host->username ?? 'Unknown User' }}
                    </p>
                    <div class="flex space-x-1 text-sm text-gray-500">
                        @if(!$event->tmp_event_id)
                            <span>Phoenix</span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
