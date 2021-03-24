{{-- Success is as dangerous as failure. --}}

@section('title', 'Events Overview')

@section('hero-title')
    <span>Event</span>
    <span class="text-orange-600">Leaderboard</span>
@endsection

@section('hero-description')
    In Phoenix, drivers get rewarded with Event XP for every event they attend. Based on the importance of that event, the amount of XP is decided by our Event Staff.
    <br><br>
    On this page, you can view our most active event attendees, as well as taking an in-depth look into our event numbers.
@endsection

@section('hero-image', 'https://phoenixvtc.com/img/dd9f153d-a7b5-477d-be78-9cc4014aeeab/227300-20210216162827-11.png?fm=jpg&q=80&fit=max&crop=1920%2C1002%2C0%2C78')

<div>
    <!-- Event Statistics -->
    <div class="bg-gray-800">
        <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
            <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl pb-16">
                <h2 class="text-base font-semibold tracking-wider text-orange-600 uppercase">Global</h2>
                <p class="mt-2 text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    Event Statistics
                </p>
                <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
                    At Phoenix we love events and aim to attend lots of public events each month, as well as hosting our own monthly public convoy and regular private member convoys.
                    <br><br>
                    Our numbers don't lie, and we aren't afraid to show them.
                </p>
            </div>
            <div class="grid gap-10 row-gap-8 lg:grid-cols-3">
                <div>
                    <div class="flex">
                        <h6 class="mr-2 text-4xl font-bold md:text-5xl text-orange-600">
                            {{-- Static number is the amount of events before we released the events system (April 1st, 2021) --}}
                            {{ 30 + $statistics['events_attended'] }}
                        </h6>
                        <div class="flex items-center justify-center rounded-full bg-orange-600 w-7 h-7">
                            <x-heroicon-o-lightning-bolt class="text-white w-5 h-5"/>
                        </div>
                    </div>
                    <p class="mb-2 font-bold md:text-lg text-gray-100">Events Attended</p>
                    <p class="text-gray-500">
                        These are external events, not hosted by us, which Phoenix officially attended.
                    </p>
                </div>
                <div>
                    <div class="flex">
                        <h6 class="mr-2 text-4xl font-bold md:text-5xl text-orange-600 ">
                            {{-- Static number is the amount of events before we released the events system (April 1st, 2021) --}}
                            {{ 22 + $statistics['events_hosted'] }}
                        </h6>
                        <div class="flex items-center justify-center rounded-full bg-orange-600 w-7 h-7">
                            <x-heroicon-o-lightning-bolt class="text-white w-5 h-5"/>
                        </div>
                    </div>
                    <p class="mb-2 font-bold md:text-lg text-gray-100">Events Hosted</p>
                    <p class="text-gray-500">
                        These events are hosted & organized by the Phoenix Event Staff, both public and private.
                    </p>
                </div>
                <div>
                    <div class="flex">
                        <h6 class="mr-2 text-4xl font-bold md:text-5xl text-orange-600">
                            {{-- Static number is the KM (average) in events before we released the events system (April 1st, 2021) --}}
                            {{ number_format(63600 + $statistics['total_distance']) }}
                            <span class="text-2xl md:text-3xl">km</span>
                        </h6>
                        <div class="flex items-center justify-center rounded-full bg-orange-600 w-7 h-7">
                            <x-heroicon-o-lightning-bolt class="text-white w-5 h-5"/>
                        </div>
                    </div>
                    <p class="mb-2 font-bold md:text-lg text-gray-100">Total Event Distance</p>
                    <p class="text-gray-500">
                        The total distance driven while in events, ETS2 and ATS combined.
                    </p>
                </div>
            </div>
            <div class="pt-16">
                <p class="text-gray-400 text-sm text-center">
                    Counted since January 9th, 2021. Updated every 24 hours.
                </p>
            </div>
        </div>
    </div>

    <!-- All-time Leaderboard -->
    <div class="relative py-16 sm:py-24 lg:py-32">
        <div class="relative">
            <div class="text-center mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
                <p class="mt-2 text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    <span class="text-orange-600">All-time</span> Leaderboard
                </p>
                <p class="mt-5 mx-auto max-w-prose text-xl text-gray-500">
                    Take a look at out most active drivers within events.
                    <br>
                    This leaderboard updates every 15 minutes.
                </p>
            </div>
            <div class="max-w-7xl mx-auto mt-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-12 sm:px-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="self-center">
                                <img src="{{ asset('icons/trophy.svg') }}" alt="Trophy Icon" class="text-white h-20"/>
                            </div>
                            <div class="self-center text-right">
                                <div class="flex flex-col capitalize">
                                    <h1 class="text-3xl font-bold">EVENT XP</h1>
                                    <h3 class="text-xl">TOP 10</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-5 sm:p-6 bg-gray-100">
                        <ul class="space-y-3">
                            @foreach($event_wallets_all_time as $wallet)
                                <li class="bg-white shadow-xl overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-16 w-16 rounded-full"
                                                     src="{{ $wallet->holder->profile_picture }}"
                                                     alt="{{ $wallet->holder->username }}">
                                            </div>
                                            <div class="min-w-0 flex-1 px-4 md:gap-4">
                                                <p class="text-2xl font-bold text-orange-600 truncate">{{ $wallet->holder->username }}</p>
                                                <p class="mt-2 flex items-center text-sm text-gray-600">
                                                    <x-heroicon-o-star
                                                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500"/>
                                                    <span class="truncate">{{ $wallet->balance }} Event XP</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <h1 class="text-black @if($loop->iteration === 1) text-4xl @else text-2xl @endif">@th($loop->iteration)</h1>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            @if(Auth::check() && !$event_wallets_all_time->contains('holder_id', Auth::id()))
                                <li class="bg-white shadow-xl overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-16 w-16 rounded-full"
                                                     src="{{ Auth::user()->profile_picture }}"
                                                     alt="{{ Auth::user()->username }}">
                                            </div>
                                            <div class="min-w-0 flex-1 px-4 md:gap-4">
                                                <p class="text-2xl font-bold text-orange-600 truncate">{{ Auth::user()->username }}</p>
                                                <p class="mt-2 flex items-center text-sm text-gray-600">
                                                    <x-heroicon-o-star
                                                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-500"/>
                                                    <span class="truncate">{{ Auth::user()->getWallet('event-xp')->balance ?? 0 }} Event XP</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:events.components.call-to-action
        title="Did we convince you yet?"
        button-text="Join us in this journey"
        button-url="https://phoenixvtc.com/en/apply"
        background-color="bg-orange-600"
        text-color="text-gray-100"
        description="At Phoenix we believe that VTCs are meant to come together and create new memories.<br><br>What are you waiting for, break the mould and apply now!">
    </livewire:events.components.call-to-action>
</div>
