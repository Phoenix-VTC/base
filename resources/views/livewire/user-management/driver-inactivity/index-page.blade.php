{{-- The best athlete wants his opponent at his best. --}}

@section('title', 'Driver Inactivity')

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
                                    User ID
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
                                    LOA
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View Job Overview</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inactive_drivers as $user)
                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                                        <a href="{{ route('users.profile', $user) }}"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            {{ $user->username ?? 'Deleted User' }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->total_jobs }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->total_distance }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->toFormattedDateString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($user->active_vacation_requests->count())
                                            @foreach($user->active_vacation_requests as $vacation_request)
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
                        <x-empty-state :image="asset('img/illustrations/map_dark.svg')"
                                       alt="Map illustration">
                            Hmm, it looks like you don't have any submitted jobs yet.
                            <br>
                            Come back here when you've finished some!
                        </x-empty-state>
                    @endempty
                    {{ $inactive_drivers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
