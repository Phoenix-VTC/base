@section('title', 'Your Vacation Requests')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('vacation-requests.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            New vacation request
        </a>
    </div>
@endsection

<div>
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
                                        class="px-6 py-3 whitespace-nowrap text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                        @if($vacation_request->leaving)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" colspan="2">
                                                <span
                                                    class="px-2 ml-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Leaving Phoenix
                                                </span>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <time datetime="{{ $vacation_request->start_date }}">
                                                    {{ $vacation_request->start_date->format('M d, Y') }}
                                                </time>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <time datetime="{{ $vacation_request->end_date }}">
                                                    {{ $vacation_request->end_date->format('M d, Y') }}
                                                </time>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $vacation_request->reason }}
                                        </td>
                                        <td class="px-6 py-4 flex text-sm text-gray-500">
                                            @isset($vacation_request->handled_by)
                                                {{ $vacation_request->staff->username ?? 'Unknown User' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $vacation_request->getStatus()['color'] }}-100 text-{{ $vacation_request->getStatus()['color'] }}-800">
                                                {{ ucwords($vacation_request->getStatus()['status']) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <x-empty-state :image="asset('img/illustrations/travel_plans.svg')"
                                           alt="Travel plans illustration">
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
