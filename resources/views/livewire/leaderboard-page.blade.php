{{-- Nothing in the world is as soft and yielding as water. --}}

@section('title', 'Leaderboard')

<div>
    <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
        @foreach($users->take(3) as $user)
            <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow-xl divide-y divide-gray-200 @if($user->id === Auth::id()) border-2 border-orange-300 @endif">
                <div class="flex-1 flex flex-col p-8">
                    <img class="w-32 h-32 flex-shrink-0 mx-auto bg-black rounded-full"
                         src="{{ $user->profile_picture ?? '' }}"
                         alt="{{ $user->username }}'s Profile Picture">
                    <h3 class="mt-6 text-gray-900 text-2xl font-semibold">{{ $user->username ?? 'Deleted User' }}</h3>
                    <dl class="mt-1 flex-grow flex flex-col justify-between">
                        <dt class="sr-only">Distance</dt>
                        <dd class="text-gray-500">{{ number_format($user->jobs_distance_sum) }} km</dd>
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
                        <dt class="sr-only">Distance</dt>
                        <dd class="text-gray-500">{{ number_format($user->jobs_distance_sum) }} km</dd>
                        <dt class="sr-only">Position</dt>
                        <dd class="mt-3">
                            <span class="text-gray-500">@th($loop->iteration)</span>
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
</div>
