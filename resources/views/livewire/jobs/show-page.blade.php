{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

@section('title', "Viewing Job #$job->id")

<div>
    <x-alert/>

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
                                    {{ number_format($job->estimated_income) }}
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">
                                    Total Income
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ number_format($job->total_income) }}
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
                                    {{ $job->pricePerDistance }} {{ App\Models\Game::getCurrency($job->game_id) ?? '??' }}
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-switch-horizontal class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium"
                                      title="Difference between the estimated and total income">Income difference:</span>
                                <span class="text-gray-900 text-sm font-bold">
                                    {{ $job->total_income - $job->estimated_income }} {{ App\Models\Game::getCurrency($job->game_id) ?? '??' }}
                                </span>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center"></div>
                            </div>

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

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-calendar class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Submitted on</span>
                                <span class="text-gray-900 text-sm font-bold">
                                    {{ $job->created_at->format('M d, Y') }}
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
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
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
                            </div>

                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                         src="{{ $job->user->profile_picture ?? asset('svg/unknown_avatar.svg') }}"
                                         alt="{{ $job->user->username ?? 'Unknown User' }}">
                                </div>
                                <div class="ml-3">
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <span>Submitted By</span>
                                    </div>
                                    <p class="text-sm font-medium capitalize text-gray-900">
                                        {{ $job->user->username ?? 'Unknown User' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if($job->user_id === Auth::id() || Auth::user()->can('manage users'))
                <section aria-labelledby="actions-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                        @if($job->user_id === Auth::id())
                            <h2 id="actions-title" class="text-lg font-medium text-gray-900">Actions</h2>
                        @else
                            <h2 id="actions-title" class="text-lg font-medium text-red-700">Staff Actions</h2>
                        @endif

                        <div class="mt-6 flex flex-col justify-stretch space-y-3">
                            <a class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                               href="#">
                                <x-heroicon-s-pencil-alt class="-ml-1 mr-3 h-5 w-5"/>
                                Edit
                            </a>

                            @if(Auth::user()->can('manage users'))
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="confirm('Are you sure you want to delete this job? This action is irreversible.') || event.stopImmediatePropagation()"
                                    wire:click="delete">
                                    <x-heroicon-s-trash class="-ml-1 mr-3 h-5 w-5"/>
                                    Delete
                                </button>
                            @else
                                <p class="text-center text-xs text-gray-500">
                                    Please contact a Human Resources member in order to delete this job.
                                </p>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
