@section('title', 'Events')

@section('hero-title')
    <span>Phoenix</span>
    <span class="text-orange-600">Events</span>
@endsection

@section('hero-description')
    Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.
@endsection

@section('hero-image', 'https://phoenixvtc.com/img/fc4b88a6-7864-41d8-a79b-eda11a2b915c/euro-truck-simulator-2-screenshot-20210108-14360243-edit.png')

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
                    Phasellus lorem quam molestie id quisque diam aenean nulla in. Accumsan in quis quis
                    nunc, ullamcorper malesuada. Eleifend condimentum id viverra nulla.
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
                   href="#">
                    View all events
                    {{-- chevron-double-right --}}
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
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
                href="#">
                    View all events
                    {{-- chevron-double-right --}}
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <livewire:events.components.call-to-action
        tag="Hosting an event?" title="Invite Phoenix"
        button-text="Contact our event team"
        button-url="#"
        background-color="bg-gray-800"
        description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et, egestas tempus tellus etiam sed. Quam a scelerisque amet ullamcorper eu enim et fermentum, augue. Aliquet amet volutpat quisque ut interdum tincidunt duis.">
    </livewire:events.components.call-to-action>
</div>
