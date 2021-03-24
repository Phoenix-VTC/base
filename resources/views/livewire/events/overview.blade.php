{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

@section('title', 'Events Overview')

@section('hero-title')
    <span>Phoenix</span>
    <span class="text-orange-600">Events</span>
@endsection

@section('hero-description')
    At Phoenix we love events and aim to attend lots of public events each month, as well as hosting our own monthly public convoy and regular private member convoys.
@endsection

@section('hero-image', 'https://phoenixvtc.com/img/fc4b88a6-7864-41d8-a79b-eda11a2b915c/euro-truck-simulator-2-screenshot-20210108-14360243-edit.png')

<div>
    <!-- Featured Events -->
    <div class="relative bg-gray-800 py-16 sm:py-24 lg:py-32">
        <div class="relative">
            <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                <h2 class="text-base font-semibold tracking-wider text-orange-600 uppercase">Phoenix</h2>
                <p class="mt-2 text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    All Events
                </p>
                <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
                    Browse through all of our upcoming events here.
                    <br>
                    If you're a member, make sure that you are logged in to view member-only events.
                </p>
            </div>
            <div
                class="mt-12 mx-auto max-w-md px-4 grid gap-8 sm:max-w-lg sm:px-6 lg:px-8 lg:grid-cols-3 lg:max-w-7xl">
                @foreach($events as $event)
                    <livewire:events.components.event-card :event="$event"/>
                @endforeach
            </div>
            <div class="mt-12">
                <div class="mx-auto max-w-md sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                    {{ $events->links('components.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <livewire:events.components.call-to-action
        tag="Sounds good?"
        title="Join Phoenix"
        button-text="Apply Now"
        button-url="https://phoenixvtc.com/en/apply"
        background-color="bg-orange-600"
        text-color="text-gray-100"
        description="We're a fairly new VTC, founded by experienced members of the VTC Community, who believe in forward-thinking and strive for excellence.">
    </livewire:events.components.call-to-action>
</div>
