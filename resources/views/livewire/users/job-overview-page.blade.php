{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day --}}

@section('title', 'Viewing ' . $user->username . '\'s jobs')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('users.profile', $user) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-identification class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            View {{ $user->username }}'s profile
        </a>
    </div>
@endsection

<div>
    <x-alert/>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    @empty(!$jobs->count())
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Game
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    From
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    To
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Distance
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $job)
                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                                        @switch($job->status->key)
                                            @case('Incomplete')
                                            <div
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <span>Incomplete</span>
                                            </div>
                                            @break
                                            @case('PendingVerification')
                                            <div
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                <span>Pending Verification</span>
                                            </div>
                                            @break
                                            @case('Complete')
                                            <div
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <span>Completed</span>
                                            </div>
                                            @break
                                            @default
                                            <div
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                <span>Unknown Status</span>
                                            </div>
                                            @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ App\Models\Game::getAbbreviationById($job->game_id) ?? 'Unknown Game' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucwords($job->pickupCity->real_name ?? 'Unknown City') }}
                                        ({{ ucwords($job->pickupCompany->name ?? 'Unknown Company') }})
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucwords($job->destinationCity->real_name ?? 'Unknown City') }}
                                        ({{ ucwords($job->destinationCompany->name ?? 'Unknown Company') }})
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($job->game_id === 2)
                                            {{ number_format($job->distance / 1.609) }}
                                        @else
                                            {{ number_format($job->distance) }}
                                        @endif
                                        {{ App\Models\Game::getAbbreviationDistanceMetric($job->game_id) ?? '??' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <x-empty-state :image="asset('img/illustrations/no_data.svg')"
                                       alt="No Data illustration">
                            Hmm, it looks like this user hasn't submitted any jobs yet.
                        </x-empty-state>
                    @endempty
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
