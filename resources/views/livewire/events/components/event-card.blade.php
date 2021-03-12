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
                <span>{{ $event->start_date->format('d M H:m') }}</span>
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
                        Event Points
                    </span>
                </div>

                @if($event->is_high_rewarding)
                    <div class="flex space-x-2 text-sm font-bold text-red-600">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M14.064 0a8.75 8.75 0 00-6.187 2.563l-.459.458c-.314.314-.616.641-.904.979H3.31a1.75 1.75 0 00-1.49.833L.11 7.607a.75.75 0 00.418 1.11l3.102.954c.037.051.079.1.124.145l2.429 2.428c.046.046.094.088.145.125l.954 3.102a.75.75 0 001.11.418l2.774-1.707a1.75 1.75 0 00.833-1.49V9.485c.338-.288.665-.59.979-.904l.458-.459A8.75 8.75 0 0016 1.936V1.75A1.75 1.75 0 0014.25 0h-.186zM10.5 10.625c-.088.06-.177.118-.266.175l-2.35 1.521.548 1.783 1.949-1.2a.25.25 0 00.119-.213v-2.066zM3.678 8.116L5.2 5.766c.058-.09.117-.178.176-.266H3.309a.25.25 0 00-.213.119l-1.2 1.95 1.782.547zm5.26-4.493A7.25 7.25 0 0114.063 1.5h.186a.25.25 0 01.25.25v.186a7.25 7.25 0 01-2.123 5.127l-.459.458a15.21 15.21 0 01-2.499 2.02l-2.317 1.5-2.143-2.143 1.5-2.317a15.25 15.25 0 012.02-2.5l.458-.458h.002zM12 5a1 1 0 11-2 0 1 1 0 012 0zm-8.44 9.56a1.5 1.5 0 10-2.12-2.12c-.734.73-1.047 2.332-1.15 3.003a.23.23 0 00.265.265c.671-.103 2.273-.416 3.005-1.148z"/>
                        </svg>
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
