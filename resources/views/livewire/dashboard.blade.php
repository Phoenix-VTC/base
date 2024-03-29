@section('title', 'Hi, ' . Auth::user()->username . '!')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endpush

<div>
    @if(!Auth::user()->discord)
        <div class="p-4 mb-8 border-l-4 border-yellow-400 bg-yellow-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-s-information-circle class="w-5 h-5 text-yellow-400"/>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Hey, you haven't connected your Discord account yet! You will need this in the future.
                        <br>
                        <a href="{{ route('settings.socials') }}"
                           class="font-medium text-yellow-700 underline hover:text-yellow-600">
                            Go to your settings now.
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div>
        <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">
            This month
        </h3>

        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <livewire:jobs.components.statistic
                icon="o-clipboard-list"
                title="My Deliveries"
                :route="route('jobs.personal-overview')"
                :content="$personal_stats['delivery_count']['current_month']"
                :change-number="abs($personal_stats['delivery_count']['previous_month'] - $personal_stats['delivery_count']['current_month'])"
                :increased="($personal_stats['delivery_count']['current_month'] > $personal_stats['delivery_count']['previous_month'])"
            />

            <livewire:jobs.components.statistic
                icon="o-currency-euro"
                title="My Income"
                :route="route('my-wallet')"
                content="{!! Auth::user()->preferred_currency_symbol !!} {{ number_format($personal_stats['income']['current_month']) }}"
                :change-number="number_format(abs($personal_stats['income']['previous_month'] - $personal_stats['income']['current_month']))"
                :increased="($personal_stats['income']['current_month'] > $personal_stats['income']['previous_month'])"
            />

            <livewire:jobs.components.statistic
                icon="o-truck"
                title="My Distance"
                :route="route('jobs.personal-overview')"
                content="{{ number_format($personal_stats['distance']['current_month']) }} {{ Auth::user()->preferred_distance_abbreviation }}"
                :change-number="number_format(abs($personal_stats['distance']['previous_month'] - $personal_stats['distance']['current_month']))"
                :increased="($personal_stats['distance']['current_month'] > $personal_stats['distance']['previous_month'])"
            />

        </dl>
    </div>

    <div
        class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        {{-- Left col --}}
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">

            <div class="flex flex-col">
                <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">
                    Today's overview
                </h3>
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Driver
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Distance
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Delivered Jobs
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($today_overview as $user)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                            <a href="{{ route('users.profile', $user) }}"
                                               class="font-medium hover:font-semibold">
                                                {{ $user->username ?? 'Unknown User' }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $user->jobs_distance_sum }} km
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $user->jobs->count() }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$today_overview->count())
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            Aww, no one submitted any jobs yet for today..
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if($today_overview->count())
                                <div class="px-6 py-2 text-center">
                                        <span class="text-sm text-gray-700">
                                            Showing a maximum of 10 users
                                        </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="overflow-hidden bg-gray-200 divide-y divide-gray-200 rounded-lg shadow sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">

                <div
                    class="relative p-6 bg-white rounded-tl-lg rounded-tr-lg sm:rounded-tr-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-teal-700 rounded-lg bg-teal-50 ring-4 ring-white">
                            <x-heroicon-o-calendar class="w-6 h-6"/>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <a href="{{ route('events.home') }}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Events
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            At Phoenix we love events and aim to attend lots of public events each month, as well as
                            hosting our own monthly public convoy and regular private member convoys.
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative p-6 bg-white sm:rounded-tr-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-pink-700 rounded-lg bg-pink-50 ring-4 ring-white">
                            <x-heroicon-o-briefcase class="w-6 h-6"/>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <a href="{{ route('jobs.personal-overview') }}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                My Jobs
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Submit some new jobs to keep up with our monthly requirements!
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-red-700 rounded-lg bg-red-50 ring-4 ring-white">
                            <x-heroicon-o-truck class="w-6 h-6"/>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <a href="https://truckersmp.com/vtc/30294" target="_blank" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                TruckersMP
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Join our VTC Page, view our latest news posts, and upcoming public events!
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-blue-700 rounded-lg bg-blue-50 ring-4 ring-white">
                            <x-heroicon-o-camera class="w-6 h-6"/>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <a href="{{ route('screenshot-hub.index') }}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Screenshot Hub
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Want to show off that sweet screenshot you took? This is the place to be!
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative p-6 bg-white sm:rounded-bl-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-yellow-700 rounded-lg bg-yellow-50 ring-4 ring-white">
                            <x-heroicon-o-cash class="w-6 h-6"/>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <a href="{{ route('my-wallet') }}" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                My Wallet
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            View your current Event XP and job income balance here, including your recent
                            transactions!
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative p-6 bg-white rounded-bl-lg rounded-br-lg sm:rounded-bl-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="inline-flex p-3 text-purple-700 rounded-lg bg-purple-50 ring-4 ring-white">
                            <img src="{{ asset('icons/discord.svg') }}" alt="Discord" class="w-6 h-6" height="24"
                                 width="24"/>
                        </span>
                    </div>
                    <div class="mt-8">
                        <h3 class="text-lg font-medium">
                            <a href="https://discord.gg/jw4WgPDsBK" target="_blank" class="focus:outline-none">
                                <!-- Extend touch target to entire panel -->
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                Phoenix Discord
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Our Discord server is <i>the</i> place to be. Chat with our lovely Community Members,
                            Drivers, Staff Members, and stay up-to-date with the latest updates and changes!
                        </p>
                    </div>
                    <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

            </div>

        </div>
        {{-- End of left col --}}

        {{-- Right col --}}
        <div class="space-y-6 lg:col-start-3 lg:col-span-1">

            <x-driver-level-doughnut-card/>

            <section aria-labelledby="job-activity-feed-title" class="lg:col-start-3 lg:col-span-1">
                <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                    <h2 id="job-activity-feed-title" class="text-lg font-medium text-gray-900">Recent jobs</h2>

                    <!-- Job Activity Feed -->
                    <div class="flow-root mt-6">
                        <ul class="-mb-8">
                            @if($recent_jobs->count())
                                @foreach($recent_jobs as $job)
                                    @if($job->user()->exists())
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                          aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <a class="flex items-center justify-center w-8 h-8 bg-gray-400 rounded-full ring-8 ring-white"
                                                           href="{{ route('users.profile', $job->user) }}">
                                                            <img class="w-8 h-8 rounded-full"
                                                                 src="{{ $job->user->profile_picture ?? '' }}"
                                                                 alt="{{ $job->user->username ?? 'Unknown Username' }}"
                                                                 height="32" width="32"/>
                                                        </a>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <a href="{{ route('jobs.show', $job) }}">
                                                            <p class="text-sm text-gray-500">
                                                                <span class="font-medium text-gray-900">
                                                                    {{ $job->user->username }}
                                                                </span>
                                                                <br>
                                                                Submitted a job to
                                                                <span class="font-medium text-gray-900">
                                                                    {{ $job->destinationCity->real_name }}
                                                                </span>
                                                                @if($job->game_id === 1)
                                                                    [{{ $job->distance }} km]
                                                                @else
                                                                    [{{ round($job->distance / 1.609) }} mi]
                                                                @endif
                                                            </p>
                                                        </a>
                                                        <div class="text-sm text-right text-gray-500 whitespace-nowrap">
                                                        <span title="{{ $job->created_at->toDateTimeString() }}">
                                                            {{ $job->created_at->isoFormat('HH:mm') }}
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                            <span
                                                class="flex items-center justify-center w-8 h-8 rounded-full ring-8 ring-white">
                                                <x-heroicon-o-emoji-sad class="w-8 h-8 text-gray-400"/>
                                            </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Aww, there are no recent jobs!
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>

            @isset($online_users)
                <section aria-labelledby="online-users-title">
                    <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-900">
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white" id="online-users-title">
                                Online Users
                            </h2>
                            <div class="flow-root mt-6">
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    @foreach($online_users->take(7) as $user)
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <span class="relative inline-block">
                                                        <img class="w-8 h-8 rounded-full"
                                                             src="{{ $user['profile_picture'] }}"
                                                             alt="{{ $user['username'] }}'s profile picture">
                                                        <span
                                                            class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white @if($user['away']) bg-orange-400 @else bg-green-400 @endif"></span>
                                                    </span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{ $user['username'] }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('users.profile', $user['id']) }}"
                                                       class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 dark:border-gray-600 text-sm leading-5 font-medium rounded-full text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                        View Profile
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @if($online_users->count() > 7)
                                        <p class="py-4 text-xs text-center text-gray-500">
                                            And {{ $online_users->count() - 7 }} other {{ Str::plural('user', ($online_users->count() - 7)) }}
                                        </p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            @endisset

            <section aria-labelledby="news-title">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-base font-medium text-gray-900" id="news-title">Recent News Posts</h2>
                        <div class="flow-root mt-6">
                            <ul class="-my-5 divide-y divide-gray-200">
                                @if(!empty($recent_news))
                                    @foreach(array_slice($recent_news, 0, 3) as $post)
                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <h3 class="text-sm font-semibold text-gray-800">
                                                    <a href="{{ $post['link'] }}" target="_blank"
                                                       class="hover:underline focus:outline-none">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        {{ $post['title'] }}
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                    {{ \Illuminate\Support\Str::words($post['description'], 20) }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="mb-5 text-gray-600 line-clamp-2">
                                        Oh no! Something went wrong while trying to load our news posts.
                                        Please try again later.
                                    </p>
                                @endisset
                            </ul>
                        </div>
                        <div class="mt-6">
                            <a href="https://phoenixvtc.com/en/news" target="_blank"
                               class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                View all
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        {{-- End of right col --}}
    </div>
</div>
