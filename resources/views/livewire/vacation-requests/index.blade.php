@section('title', 'Your Vacation Requests')

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
                            <!-- Odd row -->
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $vacation_request->staff->username ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="overflow-hidden shadow bg-white text-center">
                            <div class="px-4 py-5 sm:px-6 mt-4 flex">
                                <img class="mx-auto" width="45%" src="{{ asset('img/illustrations/travel_plans.svg') }}"
                                     alt="Travel plans illustration"/>
                            </div>
                            <div class="px-4 py-5 sm:p-6">
                                <h1 class="text-4xl font-semibold text-gray-900">
                                    Going away for a while?
                                    <br>
                                    Your vacation requests will show here.
                                </h1>
                            </div>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </div>
</div>
