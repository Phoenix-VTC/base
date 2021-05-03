{{-- In work, do what you enjoy. --}}

@section('title', 'Choose a game')

<div>
    <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">

        <li class="relative">
            <a href="{{ route('jobs.submit', 1) }}">
                <div
                    class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                    <img src="{{ asset('img/game_covers/ets2.png') }}" alt="Euro Truck Simulator 2 Cover"
                         class="object-cover pointer-events-none group-hover:opacity-75">
                    <button type="button" class="absolute inset-0 focus:outline-none">
                        <span class="sr-only">Choose Euro Truck Simulator 2</span>
                    </button>
                </div>
                <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                    Euro Truck Simulator 2
                </p>
            </a>
        </li>

        <li class="relative">
            <a href="{{ route('jobs.submit', 2) }}">
                <div
                    class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                    <img src="{{ asset('img/game_covers/ats.jpg') }}" alt="American Truck Simulator Cover"
                         class="object-cover pointer-events-none group-hover:opacity-75">
                    <button type="button" class="absolute inset-0 focus:outline-none">
                        <span class="sr-only">Choose American Truck Simulator</span>
                    </button>
                </div>
                <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                    American Truck Simulator
                </p>
            </a>
        </li>

    </ul>

</div>
