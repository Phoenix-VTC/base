<div>
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl font-semibold text-gray-900">
            Your Vacation Requests
        </h3>
        <div class="mt-3 sm:mt-0 sm:ml-4">
            <a href="{{ route('vacation-requests.create') }}"
               class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange active:bg-orange-700">
                New vacation request
            </a>
        </div>
    </div>

    <x-alert/>

    <div class="mt-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        @empty(!$vacation_requests->count())
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        End Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reason
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Handled By
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vacation_requests as $vacation_request)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <time datetime="{{ $vacation_request->start_date }}">
                                                {{ $vacation_request->start_date }}
                                            </time>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <time datetime="{{ $vacation_request->end_date }}">
                                                {{ $vacation_request->end_date }}
                                            </time>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vacation_request->reason }}
                                            @if($vacation_request->leaving)
                                                <div
                                                    class="px-2 ml-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Leaving Phoenix
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vacation_request->staff->username ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @empty($vacation_request->claimed_by)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @else
                                                @if($vacation_request->is_upcoming)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Upcoming
                                                    </span>
                                                @endif

                                                @if($vacation_request->is_active)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @endif

                                                @if($vacation_request->is_expired)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Expired
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <x-empty-state :image="asset('img/illustrations/travel_plans.svg')" alt="Travel plans illustration">
                                Going away for a while?
                                <br>
                                Your vacation requests will show here.
                            </x-empty-state>
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
