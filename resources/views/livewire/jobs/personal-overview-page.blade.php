{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@section('title', 'Personal Job Overview')

@section('meta')
    <x-header.meta-item icon="s-cash">
        {!! Auth::user()->preferred_currency_symbol !!} {{ number_format(Auth::user()->default_wallet_balance) }}
    </x-header.meta-item>
@endsection

@section('actions')
    <div class="ml-3">
        <a href="{{ route('jobs.submit') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-truck class="-ml-1 mr-2 h-5 w-5"/>
            Submit New Job
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
                        <x-empty-state :image="asset('img/illustrations/map_dark.svg')"
                                       alt="Events illustration">
                            Hmm, it looks like you don't have any submitted jobs yet.
                            <br>
                            Come back here when you've finished some!
                        </x-empty-state>
                    @endempty
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
