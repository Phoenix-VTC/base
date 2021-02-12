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
                    <livewire:events.components.event-card :event="$event"/>
                @endforeach
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
                    <livewire:events.components.event-card :event="$event"/>
                @endforeach
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
