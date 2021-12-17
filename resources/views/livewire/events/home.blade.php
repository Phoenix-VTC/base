@section('title', 'Events')

@section('hero-title')
    <span>Phoenix</span>
    <span class="text-orange-600">Events</span>
@endsection

@section('hero-description')
    At Phoenix we love events and aim to attend lots of public events each month, as well as hosting our own monthly public convoy and regular private member convoys.
    <br><br>
    Feel free to browse through our upcoming events here.
@endsection

{{-- TEMP-WINTER --}}
@section('hero-image', 'https://phoenix-base.s3.nl-ams.scw.cloud/images/snow_background.png')

<div>
    <!-- Featured Events -->
    <div class="relative bg-gray-800 py-16 sm:py-24 lg:py-32">
        <div class="relative">
            <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                <h2 class="text-base font-semibold tracking-wider text-orange-600 uppercase">Phoenix</h2>
                <p class="mt-2 text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    Featured Events
                </p>
                <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
                    Looking for events that will be a blast to attend? These events are what you're looking for!
                    We've selected the best upcoming events for you, and marked them as featured.
                </p>
            </div>
            <div
                class="mt-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-3 lg:max-w-7xl">
                @foreach($featured_events as $event)
                    @if($event->public_event || $event->external_event || (Auth::check() && !$event->public_event))
                        <livewire:events.components.event-card :event="$event"/>
                    @endif
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                   href="{{ route('events.overview') }}">
                    View all events
                    {{-- chevron-double-right --}}
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="relative bg-gray-900 py-16 sm:py-24 lg:py-32">
        <div class="relative">
            <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                <p class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    Upcoming Events
                </p>
            </div>
            <div
                class="mt-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-3 lg:max-w-7xl">
                @foreach($upcoming_events as $event)
                    @if($event->public_event || $event->external_event || (Auth::check() && !$event->public_event))
                        <livewire:events.components.event-card :event="$event"/>
                    @endif
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                   href="{{ route('events.overview') }}">
                    View all events
                    {{-- chevron-double-right --}}
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <livewire:events.components.call-to-action
        tag="Hosting an event?" title="Invite Phoenix"
        button-text="Contact our event team"
        button-url="mailto:events@phoenixvtc.com"
        background-color="bg-gray-800"
        description="We are very active within the TruckersMP Community, attending lots of Public Events as well as hosting our own.<br><br>If you would like Phoenix to attend your event, feel free to reach out to us!">
    </livewire:events.components.call-to-action>
</div>
