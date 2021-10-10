{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

@section('title', "Viewing Job #$job->id")

@section('actions')
    @if($job->user_id === Auth::id() && $job->status->value === \App\Enums\JobStatus::Incomplete)
        <div class="ml-3">
            <x-app-ui::button tag="a" href="{{ route('jobs.verify', $job->id) }}" icon="iconic-check">
                Verify job
            </x-app-ui::button>
        </div>
    @endif
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
                function(response, status) {
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

    @if($job->user_id === Auth::id() && $job->status->value === \App\Enums\JobStatus::PendingVerification)
        <x-app-ui::alert icon="iconic-information" color="warning">
            <x-slot name="heading">
                Pending verification
            </x-slot>

            A city, company or cargo used in this job doesn't exist in our database yet. That's why this job is on pending verification.
            <br>
            Once this new game data entry has been approved, you will be able to submit your job!
        </x-app-ui::alert>
    @endif

    <div
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <!-- Delivery Information -->
            <section aria-labelledby="delivery-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="delivery-information-title" class="text-lg leading-6 font-medium text-gray-900">
                            Delivery Information
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Information about the submitted delivery
                        </p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
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
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Field Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Old Value
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            New Value
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($job->revisionHistoryWithUser as $revision)
                                        <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 prose prose-sm">
                                                @if($revision->user_id)
                                                    <a href="{{ route('users.profile', $revision->user_id) }}">
                                                        {{ $revision->user->username ?? 'Deleted User' }}
                                                    </a>
                                                @else
                                                    <span class="font-semibold">System</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $revision->fieldName() ?? 'Unknown' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $revision->oldValue() ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $revision->newValue() ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $revision->created_at }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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

        <div class="lg:col-start-3 lg:col-span-1 space-y-6">
            <section aria-labelledby="job-title" class="lg:col-start-3 lg:col-span-1">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="job-title" class="text-lg font-medium text-gray-900">Job Information</h2>

                    <div class="mt-6 flow-root">
                        <div class="space-y-5">
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-calculator class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Price per distance:</span>
                                <span class="text-gray-900 text-sm font-bold">
                                    {{ App\Models\Game::getCurrencySymbol($job->game_id) ?? '??' }} {{ $job->pricePerDistance }}
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-switch-horizontal class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium"
                                      title="Difference between the estimated and total income">Income difference:</span>
                                <span class="text-gray-900 text-sm font-bold">
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
                                    <x-heroicon-s-clipboard-check class="h-5 w-5 text-gray-400"/>
                                    <span class="text-gray-900 text-sm font-medium">Finished on</span>
                                    <span class="text-gray-900 text-sm font-bold">
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
                                <x-heroicon-s-calendar class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Submitted on</span>
                                <span class="text-gray-900 text-sm font-bold">
                                    {{ $job->created_at->toDayDateTimeString() }}
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-information-circle class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Status:</span>
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
                                        <x-heroicon-o-location-marker class="h-4 w-4"/>
                                    </span>
                                @endif
                            </div>

                            <div class="mt-6 flex items-center">
                                <a class="flex-shrink-0" href="{{ route('users.profile', $job->user_id) }}">
                                    <img class="h-10 w-10 rounded-full"
                                         src="{{ $job->user->profile_picture ?? asset('svg/unknown_avatar.svg') }}"
                                         alt="{{ $job->user->username ?? 'Deleted User' }}" height="40" width="40">
                                </a>
                                <div class="ml-3">
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <span>Submitted By</span>
                                    </div>
                                    <a class="text-sm font-medium capitalize text-gray-900"
                                       href="{{ route('users.profile', $job->user_id) }}">
                                        {{ $job->user->username ?? 'Deleted User' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if($job->canEdit)
                <section aria-labelledby="actions-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                        @if(Auth::user()->can('manage users'))
                            <h2 id="actions-title" class="text-lg font-medium text-red-700">Staff Actions</h2>
                        @else
                            <h2 id="actions-title" class="text-lg font-medium text-gray-900">Actions</h2>
                        @endif

                        <div class="mt-6 flex flex-col justify-stretch space-y-3">
                            <a class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                               href="{{ route('jobs.edit', $job) }}">
                                <x-heroicon-s-pencil-alt class="-ml-1 mr-3 h-5 w-5"/>
                                Edit
                            </a>

                            <button
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                onclick="confirm('Are you sure you want to delete this job? This action is irreversible.') || event.stopImmediatePropagation()"
                                wire:click="delete">
                                <x-heroicon-s-trash class="-ml-1 mr-3 h-5 w-5"/>
                                Delete
                            </button>

                            @if(Auth::user()->cannot('manage users'))
                                <p class="text-center text-sm text-gray-500">
                                    You have
                                    <strong>{{ Carbon\Carbon::now()->diffInMinutes($job->created_at->addHour(), false) . ' minute(s)' }}</strong>
                                    remaining to edit or delete this job.
                                </p>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
