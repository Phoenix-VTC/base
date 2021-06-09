{{-- Nothing in the world is as soft and yielding as water. --}}

@section('title', ucfirst($orderBy) . ' Leaderboard (' . Carbon\Carbon::create()->month($month)->startOfMonth()->isoFormat('MMMM') . ')')

@section('actions')
    @if($month !== date('m'))
        <div class="ml-3">
            <a href="{{ route('leaderboard') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <x-heroicon-s-calendar class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
                Back to {{ date('M') }}
            </a>
        </div>
    @endif

    <div class="ml-3">
        <span class="relative z-0 inline-flex shadow-sm rounded-md">
            <a href="{{ route('leaderboard', ['month' => Carbon\Carbon::create()->month($month)->startOfMonth()->subMonth()->format('m'), 'orderBy' => $orderBy]) }}"
               class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="sr-only">Previous Month</span>
                <x-heroicon-s-chevron-left class="h-5 w-5"/>
            </a>
            <span
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                {{ Carbon\Carbon::create()->month($month)->startOfMonth()->format('M') }}
            </span>
            <a href="{{ route('leaderboard', ['month' => Carbon\Carbon::create()->month($month)->startOfMonth()->addMonth()->format('m'), 'orderBy' => $orderBy]) }}"
               disabled
               class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="sr-only">Next Month</span>
                <x-heroicon-s-chevron-right class="h-5 w-5"/>
            </a>
        </span>
    </div>

    <div class="ml-3">
        <div class="relative inline-block text-left" x-data="{ open: false }">
            <div>
                <button type="button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                        id="menu-button" aria-expanded="true" aria-haspopup="true" @click="open = !open">
                    Order By
                    <x-heroicon-s-chevron-down class="-mr-1 ml-2 h-5 w-5"/>
                </button>
            </div>

            <div x-show="open" x-cloak
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                 role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                    <a href="{{ route('leaderboard', ['month' => $month, 'orderBy' => 'distance']) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900 @if($orderBy === 'distance') bg-gray-100 text-gray-900 @endif" role="menuitem" tabindex="-1" id="menu-item-0">
                        Distance
                    </a>
                    <a href="{{ route('leaderboard', ['month' => $month, 'orderBy' => 'income']) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900 @if($orderBy === 'income') bg-gray-100 text-gray-900 @endif" role="menuitem" tabindex="-1" id="menu-item-0">
                        Income
                    </a>
                    <a href="{{ route('leaderboard', ['month' => $month, 'orderBy' => 'deliveries']) }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900 @if($orderBy === 'deliveries') bg-gray-100 text-gray-900 @endif" role="menuitem" tabindex="-1" id="menu-item-0">
                        Deliveries
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<div>
    @if($users->count())
        <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
            @foreach($users->take(3) as $user)
                <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow-xl divide-y divide-gray-200 @if($user->id === Auth::id()) border-2 border-orange-300 @endif">
                    <div class="flex-1 flex flex-col p-8">
                        <img class="w-32 h-32 flex-shrink-0 mx-auto bg-black rounded-full"
                             src="{{ $user->profile_picture ?? '' }}"
                             alt="{{ $user->username }}'s Profile Picture">
                        <h3 class="mt-6 text-gray-900 text-2xl font-semibold">{{ $user->username ?? 'Deleted User' }}</h3>
                        <dl class="mt-1 flex-grow flex flex-col justify-between">
                            <dt class="sr-only">Total</dt>
                            <dd class="text-gray-500">
                                {{ number_format($user->jobs_distance_sum) ? number_format($user->jobs_distance_sum) . ' km' : '' }}
                                {{ number_format($user->jobs_total_income_sum) ? '€ ' . number_format($user->jobs_total_income_sum) : '' }}
                                {{ number_format($user->jobs_count) ? number_format($user->jobs_count) . \Illuminate\Support\Str::plural(' delivery', $user->jobs_count) : '' }}
                            </dd>
                            <dt class="sr-only">Position</dt>
                            <dd class="mt-3">
                                <span class="text-gray-500 text-lg">@th($loop->iteration)</span>
                            </dd>
                        </dl>
                    </div>
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200">
                            <div class="-ml-px w-0 flex-1 flex">
                                <a href="{{ route('users.profile', $user) }}"
                                   class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                    <x-heroicon-s-identification class="w-5 h-5 text-gray-400"/>
                                    <span class="ml-3">Profile</span>
                                </a>
                            </div>
                            <div class="w-0 flex-1 flex">
                                <a href="{{ route('users.jobs-overview', $user) }}"
                                   class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                    <x-heroicon-s-briefcase class="w-5 h-5 text-gray-400"/>
                                    <span class="ml-3">Jobs</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-6">
            @foreach($users->skip(3) as $user)
                <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200 @if($user->id === Auth::id()) border-2 border-orange-300 @endif">
                    <div class="flex-1 flex flex-col p-8">
                        <img class="w-32 h-32 flex-shrink-0 mx-auto bg-black rounded-full"
                             src="{{ $user->profile_picture ?? '' }}"
                             alt="{{ $user->username }}'s Profile Picture">
                        <h3 class="mt-6 text-gray-900 text-2xl font-semibold">{{ $user->username ?? 'Deleted User' }}</h3>
                        <dl class="mt-1 flex-grow flex flex-col justify-between">
                            <dt class="sr-only">Total</dt>
                            <dd class="text-gray-500">
                                {{ number_format($user->jobs_distance_sum) ? number_format($user->jobs_distance_sum) . ' km' : '' }}
                                {{ number_format($user->jobs_total_income_sum) ? '€ ' . number_format($user->jobs_total_income_sum) : '' }}
                                {{ number_format($user->jobs_count) ? number_format($user->jobs_count) . \Illuminate\Support\Str::plural(' delivery', $user->jobs_count) : '' }}
                            </dd>
                            <dt class="sr-only">Position</dt>
                            <dd class="mt-3">
                                <span class="text-gray-500">@th($loop->iteration + 3)</span>
                            </dd>
                        </dl>
                    </div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="-ml-px w-0 flex-1 flex">
                            <a href="{{ route('users.profile', $user) }}"
                               class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                <x-heroicon-s-identification class="w-5 h-5 text-gray-400"/>
                                <span class="ml-3">Profile</span>
                            </a>
                        </div>
                        <div class="w-0 flex-1 flex">
                            <a href="{{ route('users.jobs-overview', $user) }}"
                               class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                <x-heroicon-s-briefcase class="w-5 h-5 text-gray-400"/>
                                <span class="ml-3">Jobs</span>
                            </a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div>
            <x-empty-state :image="asset('img/illustrations/no_data.svg')"
                           alt="No Data illustration">
                Aww, there's no statistics available (yet) for this month.
            </x-empty-state>
        </div>
    @endif
</div>
