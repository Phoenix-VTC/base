{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

@section('title', "Viewing Job #$job->id")

@section('actions')
    @can('verify', $job)
        <div class="ml-3">
            <x-app-ui::button tag="a" href="{{ route('jobs.verify', $job->id) }}" icon="iconic-check">
                Verify job
            </x-app-ui::button>
        </div>
    @endcan
@endsection

@push('scripts')
    <script type="text/javascript">
        function addRoute(map) {
            const directionsService = new google.maps.DirectionsService();
            const directionsDisplay = new google.maps.DirectionsRenderer();

            directionsDisplay.setMap(map);

            const request = {
                origin: '{{ $gmaps_data['origin'] ?? null }}',
                destination: '{{ $gmaps_data['destination'] ?? null }}',
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };

            directionsService.route(
                request,
                function (response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    }
                }
            );
        }
    </script>
@endpush

<div>
    <x-alert/>

    @if($job->status->value === \App\Enums\JobStatus::PendingVerification && $job->user_id === Auth::id())
        <x-app-ui::alert icon="iconic-information" color="warning">
            <x-slot name="heading">
                Pending verification
            </x-slot>

            A city, company or cargo used in this job doesn't exist in our database yet. That's why this job is on
            pending verification.
            <br>
            Once this new game data entry has been approved, you will be able to submit your job!
        </x-app-ui::alert>
    @endif

    <div
        class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <!-- Delivery Information -->
            <section aria-labelledby="delivery-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="delivery-information-title" class="text-lg font-medium leading-6 text-gray-900">
                            Delivery Information
                        </h2>
                        <p class="max-w-2xl mt-1 text-sm text-gray-500">
                            Information about the submitted delivery
                        </p>
                    </div>
                    <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Game
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ App\Models\Game::getQualifiedName($job->game_id) ?? 'Unknown Game' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Pickup City
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $job->pickupCity->real_name ?? 'Unknown City' }},
                                    {{ $job->pickupCity->country ?? 'Unknown Country' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Destination City
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $job->destinationCity->real_name ?? 'Unknown City' }},
                                    {{ $job->destinationCity->country ?? 'Unknown Country' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Pickup Company
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $job->pickupCompany->name ?? 'Unknown Pickup Company' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Destination Company
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $job->destinationCompany->name ?? 'Unknown Destination Company' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Distance
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{-- Distance is stored in km, convert it back to mi for ATS --}}
                                    @if($job->game_id === 2)
                                        {{ number_format($job->distance / 1.609) }}
                                    @else
                                        {{ number_format($job->distance) }}
                                    @endif
                                    {{ App\Models\Game::getQualifiedDistanceMetric($job->game_id) ?? '??' }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Cargo Damage
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $job->load_damage }}%
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Estimated Income
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ App\Models\Game::getCurrencySymbol($job->game_id) ?? '??' }}
                                    {{-- Currency is stored in EUR, convert it back to USD for ATS --}}
                                    @if($job->game_id === 2)
                                        {{ number_format($job->estimated_income / 0.83) }}
                                    @else
                                        {{ number_format($job->estimated_income) }}
                                    @endif
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Total Income
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ App\Models\Game::getCurrencySymbol($job->game_id) ?? '??' }}
                                    {{-- Currency is stored in EUR, convert it back to USD for ATS --}}
                                    @if($job->game_id === 2)
                                        {{ number_format($job->total_income / 0.83) }}
                                    @else
                                        {{ number_format($job->total_income) }}
                                    @endif
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Cargo
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $job->cargo->name ?? 'Unknown Cargo' }}
                                    @if($job->cargo->mod)
                                        ({{ $job->cargo->mod ?? 'Unknown Cargo Mod' }})
                                    @endif
                                </dd>
                            </div>

                            @if($job->cargo->weight)
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Cargo Weight
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ number_format($job->cargo->weight) }} {{ App\Models\Game::getQualifiedWeightMetric($job->game_id) ?? '??' }}
                                    </dd>
                                </div>
                            @endif

                            @if($job->comments)
                                <div class="sm:col-span-2">
                                    <div class="relative">
                                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                            <div class="w-full border-t border-gray-300"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Comments
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $job->comments }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </section>

            @if(isset($gmaps_data['origin']) && isset($gmaps_data['destination']))
                <div wire:ignore>
                    <x-info-card title="Route Map">
                        <div id="map" style="width: 100%; height: 500px;">
                            {!! Mapper::render() !!}
                        </div>
                    </x-info-card>
                </div>
            @endif

            @can('manage users')
                <!-- Revision History -->
                <x-info-card title="Revision History">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            User ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Field Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Old Value
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            New Value
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Date
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($job->revisionHistoryWithUser as $revision)
                                        <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                            <td class="px-6 py-4 text-sm prose-sm prose text-gray-900 whitespace-nowrap">
                                                @if($revision->user_id)
                                                    <a href="{{ $revision->user ? route('users.profile', $revision->user) : '#' }}">
                                                        {{ $revision->user->username ?? 'Deleted User' }}
                                                    </a>
                                                @else
                                                    <span class="font-semibold">System</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $revision->fieldName() ?? 'Unknown' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $revision->oldValue() ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $revision->newValue() ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $revision->created_at }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                There is no revision history available yet for this job.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </x-info-card>
            @endcan
        </div>

        <div class="space-y-6 lg:col-start-3 lg:col-span-1">
            <section aria-labelledby="job-title" class="lg:col-start-3 lg:col-span-1">
                <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                    <h2 id="job-title" class="text-lg font-medium text-gray-900">Job Information</h2>

                    <div class="flow-root mt-6">
                        <div class="space-y-5">
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-calculator class="w-5 h-5 text-gray-400"/>
                                <span class="text-sm font-medium text-gray-900">Price per distance:</span>
                                <span class="text-sm font-bold text-gray-900">
                                    {{ App\Models\Game::getCurrencySymbol($job->game_id) ?? '??' }} {{ $job->pricePerDistance }}
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-switch-horizontal class="w-5 h-5 text-gray-400"/>
                                <span class="text-sm font-medium text-gray-900"
                                      title="Difference between the estimated and total income">Income difference:</span>
                                <span class="text-sm font-bold text-gray-900">
                                    {{ App\Models\Game::getCurrencySymbol($job->game_id) ?? '??' }} {{ $job->total_income - $job->estimated_income }}
                                </span>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center"></div>
                            </div>

                            @if($job->finished_at)
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-s-clipboard-check class="w-5 h-5 text-gray-400"/>
                                    <span class="text-sm font-medium text-gray-900">Finished on</span>
                                    <span class="text-sm font-bold text-gray-900">
                                        {{-- Only show date if time is 00:00:00 --}}
                                        @if($job->finished_at->isStartOfDay())
                                            {{ $job->finished_at->format('M d, Y') }}
                                        @else
                                            {{ $job->finished_at->toDayDateTimeString() }}
                                        @endif
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-calendar class="w-5 h-5 text-gray-400"/>
                                <span class="text-sm font-medium text-gray-900">Submitted on</span>
                                <span class="text-sm font-bold text-gray-900">
                                    {{ $job->created_at->toDayDateTimeString() }}
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-information-circle class="w-5 h-5 text-gray-400"/>
                                <span class="text-sm font-medium text-gray-900">Status:</span>
                                @switch(App\Enums\JobStatus::fromValue($job->status)->key)
                                    @case('Incomplete')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Incomplete
                                    </span>
                                    @break
                                    @case('PendingVerification')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                        Pending Verification
                                    </span>
                                    @break
                                    @case('Complete')
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                    @break
                                    @default
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        Unknown Status
                                    </span>
                                @endswitch
                                @if($job->tracker_job)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        <x-heroicon-o-location-marker class="w-4 h-4"/>
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center mt-6">
                                <a class="flex-shrink-0" href="{{ $job->user ? route('users.profile', $job->user) : '#' }}">
                                    <img class="w-10 h-10 rounded-full"
                                         src="{{ $job->user->profile_picture ?? asset('svg/unknown_avatar.svg') }}"
                                         alt="{{ $job->user->username ?? 'Deleted User' }}" height="40" width="40">
                                </a>
                                <div class="ml-3">
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <span>Submitted By</span>
                                    </div>
                                    <a class="text-sm font-medium text-gray-900 capitalize"
                                       href="{{ $job->user ? route('users.profile', $job->user) : '#' }}">
                                        {{ $job->user->username ?? 'Deleted User' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @canany(['update', 'delete', 'approve'], $job)
                <section aria-labelledby="actions-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                        @if(Auth::user()->can('manage users'))
                            <h2 id="actions-title" class="text-lg font-medium text-red-700">Staff Actions</h2>
                        @else
                            <h2 id="actions-title" class="text-lg font-medium text-gray-900">Actions</h2>
                        @endif

                        <div class="flex flex-col mt-6 space-y-3 justify-stretch">
                            @can('update', $job)
                                <a class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                   href="{{ route('jobs.edit', $job) }}">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5 mr-3 -ml-1" />
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $job)
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="confirm('Are you sure you want to delete this job? This action is irreversible.') || event.stopImmediatePropagation()"
                                    wire:click="delete">
                                    <x-heroicon-s-trash class="w-5 h-5 mr-3 -ml-1" />
                                    Delete
                                </button>
                            @endcan

                            @can('approve', $job)
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    onclick="confirm('Are you sure you want to approve this job?') || event.stopImmediatePropagation()"
                                    wire:click="approve">
                                    <x-heroicon-s-check class="w-5 h-5 mr-3 -ml-1" />
                                    Approve
                                </button>
                            @endcan

                            @if($job->isCompleted() && Auth::user()->canAny(['update', 'delete'], $job) && Auth::user()->cannot('manage users'))
                                <p class="text-sm text-center text-gray-500">
                                    You have
                                    <strong>{{ Carbon\Carbon::now()->diffInMinutes($job->created_at->addHour(), false) . ' minute(s)' }}</strong>
                                    remaining to edit or delete this job.
                                </p>
                            @endif
                        </div>
                    </div>
                </section>
            @endcanany
        </div>
    </div>
</div>
