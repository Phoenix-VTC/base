@section('title', 'Hi, ' . Auth::user()->username . '!')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endpush

<div>
    @if(!Auth::user()->discord)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-s-information-circle class="h-5 w-5 text-yellow-400"/>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Hey, you haven't connected your Discord account yet! You will need this in the future.
                        <br>
                        <a href="{{ route('settings.socials') }}"
                           class="font-medium underline text-yellow-700 hover:text-yellow-600">
                            Go to your settings now.
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
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
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        {{-- Left col --}}
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">

            <div class="flex flex-col">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
                    Today's overview
                </h3>
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Driver
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Distance
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Delivered Jobs
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($today_overview as $user)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <a href="{{ route('users.profile', $user) }}"
                                               class="font-medium hover:font-semibold">
                                                {{ $user->username ?? 'Unknown User' }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->jobs->sum('distance') }} km
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $user->jobs->count() }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$today_overview->count())
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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
                class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">

                <div
                    class="rounded-tl-lg rounded-tr-lg sm:rounded-tr-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-teal-50 text-teal-700 ring-4 ring-white">
                            <x-heroicon-o-calendar class="h-6 w-6"/>
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
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="sm:rounded-tr-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-pink-50 text-pink-700 ring-4 ring-white">
                            <x-heroicon-o-briefcase class="h-6 w-6"/>
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
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-red-50 text-red-700 ring-4 ring-white">
                            <x-heroicon-o-truck class="h-6 w-6"/>
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
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white">
                            <x-heroicon-o-camera class="h-6 w-6"/>
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
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="sm:rounded-bl-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-yellow-50 text-yellow-700 ring-4 ring-white">
                            <x-heroicon-o-cash class="h-6 w-6"/>
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
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

                <div
                    class="rounded-bl-lg rounded-br-lg sm:rounded-bl-none relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white">
                            <img src="{{ asset('icons/discord.svg') }}" alt="Discord" class="h-6 w-6" height="24"
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
                    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                          aria-hidden="true">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
                        </svg>
                    </span>
                </div>

            </div>

        </div>
        {{-- End of left col --}}

        {{-- Right col --}}
        <div class="lg:col-start-3 lg:col-span-1 space-y-6">

            <div>
                <div class="lg:col-start-3 lg:col-span-1">
                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                        <h2 class="text-lg font-medium text-gray-900">My driver level</h2>
                        <div class="pt-6 relative flex items-center h-full justify-center">
                            <div class="flex items-center h-full justify-center relative">
                                <canvas tabindex="0" class="focus:outline-none" aria-label="chart" role="img" id="progress-1" data-percent="15" width="200" height="200"></canvas>
                                <div class="w-40 h-40 absolute rounded-full flex items-center justify-center">
                                    <p tabindex="0" class="focus:outline-none text-4xl font-medium leading-10 text-center text-orange-600">
                                        {{ Auth::user()->driver_level }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex pt-6 justify-center text-center">
                            <p class="focus:outline-none text-sm leading-none text-gray-800">
                                {{ number_format(Auth::user()->jobs()->sum('distance')) }} / {{ number_format(Auth::user()->nextDriverLevelDistance) }} km
                            </p>
                        </div>
                    </div>
                </div>

                <script>
                    const percentValue = {{ Auth::user()->percentageUntilDriverLevelUp }};

                    Chart.pluginService.register({
                        afterUpdate: function (chart) {
                            if (chart.config.options.elements.arc.roundedCornersFor !== undefined) {
                                var arc = chart.getDatasetMeta(0).data[chart.config.options.elements.arc.roundedCornersFor];
                                arc.round = {
                                    x: (chart.chartArea.left + chart.chartArea.right) / 2,
                                    y: (chart.chartArea.top + chart.chartArea.bottom) / 2,
                                    radius: (chart.outerRadius + chart.innerRadius) / 2,
                                    thickness: (chart.outerRadius - chart.innerRadius) / 2 - 1,
                                    backgroundColor: arc._model.backgroundColor,
                                };
                            }
                        },

                        afterDraw: function (chart) {
                            if (chart.config.options.elements.arc.roundedCornersFor !== undefined) {
                                const ctx = chart.chart.ctx;
                                const arc = chart.getDatasetMeta(0).data[chart.config.options.elements.arc.roundedCornersFor];
                                var startAngle = Math.PI / 2 - arc._view.startAngle;
                                var endAngle = Math.PI / 2 - arc._view.endAngle;

                                ctx.save();
                                ctx.translate(arc.round.x, arc.round.y);
                                console.log(arc.round.startAngle);
                                ctx.fillStyle = arc.round.backgroundColor;
                                ctx.beginPath();
                                ctx.arc(arc.round.radius * Math.sin(startAngle), arc.round.radius * Math.cos(startAngle), arc.round.thickness, 0, 2 * Math.PI);
                                ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round.radius * Math.cos(endAngle), arc.round.thickness, 0, 2 * Math.PI);
                                ctx.closePath();
                                ctx.fill();
                                ctx.restore();
                            }
                        },
                    });
                    var config = {
                        type: "doughnut",
                        data: {
                            labels: ["Restless", "Awake"],
                            datasets: [
                                {
                                    data: [percentValue, 100 - percentValue], // Set the value shown in the chart as a percentage (out of 100)
                                    backgroundColor: ["#ff5a1f", "#fde4ce"],
                                    borderWidth: 2,
                                },
                            ],
                        },
                        options: {
                            hover: { mode: null },
                            elements: {
                                arc: {
                                    roundedCornersFor: 0,
                                },
                            },
                            cutoutPercentage: 80,
                            maintainAspectRatio: false,
                            tooltips: {
                                enabled: false,
                            },
                            legend: {
                                display: false,
                            },
                        },
                    };
                    var ctx = document.getElementById("progress-1").getContext("2d");
                    var myChart = new Chart(ctx, config);
                </script>
            </div>

            <section aria-labelledby="job-activity-feed-title" class="lg:col-start-3 lg:col-span-1">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="job-activity-feed-title" class="text-lg font-medium text-gray-900">Recent jobs</h2>

                    <!-- Job Activity Feed -->
                    <div class="mt-6 flow-root">
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
                                                        <a class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white"
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
                                                                Submitted a job to
                                                                <span class="font-medium text-gray-900">
                                                                    {{ $job->destinationCity->real_name }}
                                                                </span>
                                                            </p>
                                                        </a>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
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
                                                class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white">
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

            <section aria-labelledby="news-title">
                <div class="rounded-lg bg-white overflow-hidden shadow">
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
                               class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
