{{-- The best athlete wants his opponent at his best. --}}

@section('title', 'Driver Inactivity (' . Carbon\Carbon::create()->month($month)->startOfMonth()->isoFormat('MMMM') . ')')

@section('actions')
    @if($month !== date('m'))
        <div class="ml-3">
            <a href="{{ route('user-management.driver-inactivity.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <x-heroicon-s-calendar class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
                Back to {{ date('M') }}
            </a>
        </div>
    @endif

    <div class="ml-3">
        <span class="relative z-0 inline-flex shadow-sm rounded-md">
            <a href="{{ route('user-management.driver-inactivity.index', ['month' => Carbon\Carbon::create()->month($month)->startOfMonth()->subMonth()->format('m')]) }}"
               class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="sr-only">Previous Month</span>
                <x-heroicon-s-chevron-left class="h-5 w-5"/>
            </a>
            <span
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                {{ Carbon\Carbon::create()->month($month)->startOfMonth()->format('M') }}
            </span>
            <a href="{{ route('user-management.driver-inactivity.index', ['month' => Carbon\Carbon::create()->month($month)->startOfMonth()->addMonth()->format('m')]) }}"
               disabled
               class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="sr-only">Next Month</span>
                <x-heroicon-s-chevron-right class="h-5 w-5"/>
            </a>
        </span>
    </div>
@endsection

<div>
    <x-alert/>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    @empty(!$inactive_drivers->count())
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Username
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jobs Completed
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Driven Distance (km)
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined At
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    On LOA
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View Job Overview</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inactive_drivers as $user)
                                <tr class="@if($user->jobs_distance_sum < 1000) bg-red-100 @else bg-green-100 @endif">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                                        <a href="{{ route('users.profile', $user) }}"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            {{ $user->username ?? 'Deleted User' }}
                                        </a>
                                        @if($user->hasRole('phoenix staff'))
                                            <span
                                                class="inline-flex items-center ml-1 px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Staff
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->jobs_count ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->jobs_distance_sum ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->toFormattedDateString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($user->vacation_requests->count())
                                            @foreach($user->vacation_requests as $vacation_request)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                                    From {{ $vacation_request->start_date->toFormattedDateString() }}
                                                </span>
                                                <br>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    Until {{ $vacation_request->end_date->toFormattedDateString() }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                No
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('users.jobs-overview', $user) }}"
                                           class="text-indigo-600 hover:text-indigo-900">Job Overview</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <x-empty-state :image="asset('img/illustrations/no_data.svg')"
                                       alt="No Data illustration">
                            Hmm, it looks like there isn't any Driver Inactivity data yet.
                            <br>
                            Why don't you check back later?
                        </x-empty-state>
                    @endempty
                    {{ $inactive_drivers->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
