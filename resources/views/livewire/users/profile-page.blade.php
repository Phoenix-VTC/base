{{-- Success is as dangerous as failure. --}}

@section('title', 'Viewing ' . $user->username . '\'s profile')

<div>
    <x-alert/>

    <div
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <div class="flex flex-col">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">
                    Most recent jobs
                </h3>
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                                        Submitted At
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recent_jobs as $job)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
                                            {{ $job->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$recent_jobs->count())
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Aww, this user hasn't submitted any jobs yet..
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-start-3 lg:col-span-1 space-y-6">
            <section class="lg:col-start-3 lg:col-span-1">
                <div
                    class="bg-white mt-8 pb-6 w-full justify-center items-center overflow-hidden md:max-w-sm rounded-lg shadow-sm mx-auto">
                    <div class="relative h-40">
                        <img class="absolute h-full w-full object-cover"
                             src="https://phoenixvtc.com/img/dd9f153d-a7b5-477d-be78-9cc4014aeeab/227300-20210216162827-11.png"
                             alt="Background Image">
                    </div>

                    <div
                        class="relative shadow mx-auto h-24 w-24 -my-12 border-white rounded-full overflow-hidden border-4">
                        <img class="object-cover w-full h-full" src="{{ $user->profile_picture }}"
                             alt="{{ $user->username }}'s Profile Picture">
                    </div>

                    <div class="mt-16">
                        <h1 class="text-lg text-center font-semibold">
                            {{ $user->username }}
                        </h1>
                        <p class="text-sm text-gray-600 text-center">
                            Member since <b>{{ $user->created_at->toFormattedDateString() }}</b>
                        </p>
                    </div>

                    <div class="mt-6 pt-3 flex flex-wrap mx-6 border-t">
                        @if($user->roles->count())
                            @foreach($user->roles as $role)
                                @switch($role->name)
                                    @case('super admin')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-purple-100 text-purple-800 mr-2 mb-2">
                                    {{ ucwords($role->name) }}
                                </span>
                                    @break
                                    @case('management')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium text-white mr-2 mb-2"
                                        style="background-color: #ff0235">
                                    {{ ucwords($role->name) }}
                                </span>
                                    @break
                                    @case('phoenix staff')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium text-white mr-2 mb-2"
                                        style="background-color: #a30000">
                                    {{ ucwords($role->name) }}
                                </span>
                                    @break
                                    @case('driver')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium text-white mr-2 mb-2"
                                        style="background-color: #f48c06">
                                    {{ ucwords($role->name) }}
                                </span>
                                    @break
                                    @case('early bird')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium text-white mr-2 mb-2"
                                        style="background-color: #3498db">
                                    {{ ucwords($role->name) }}
                                </span>
                                    @break
                                    @case('beta tester')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium text-black mr-2 mb-2"
                                        style="background-color: #fbd19b">
                                    {{ ucwords($role->name) }}
                                </span>
                                    @break
                                    @default
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 mr-2 mb-2">
                                    {{ ucwords($role->name) }}
                                </span>
                                @endswitch
                            @endforeach
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 mr-2">
                                This user doesn't have any roles.
                            </span>
                        @endif
                    </div>

                    <div class="mt-6 pt-3 flex flex-col space-y-2 mx-6 border-t">
                        <a href="{{ $user->steamPlayerSummary->profileUrl ?? '#' }}" target="_blank"
                           class="relative group flex items-center space-x-2.5">
                            <i class="fab fa-steam w-4 text-gray-700 hover:text-gray-900"></i>
                            <span class="text-sm text-gray-500 group-hover:text-gray-900 font-medium truncate">
                                {{ $user->steamPlayerSummary->personaName ?? 'Unknown Steam Name' }}
                            </span>
                        </a>
                        <a href="https://truckersmp.com/user/{{ $user->truckersmp_id }}" target="_blank"
                           class="relative group flex items-center space-x-2.5">
                            <i class="fas fa-truck w-4 text-gray-700 hover:text-gray-900"></i>
                            <span class="text-sm text-gray-500 group-hover:text-gray-900 font-medium truncate">
                                {{ $user->truckersMpData['name'] ?? 'Unknown TruckersMP Name' }}
                            </span>
                        </a>
                    </div>
                </div>
            </section>

            @if(Auth::user()->can('manage users'))
                <section aria-labelledby="staff-actions-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                        <h2 id="staff-actions-title" class="text-lg font-medium text-red-700">Staff Actions</h2>

                        <div class="mt-6 flex flex-col justify-stretch space-y-3">
                            <a
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                href="#">
                                <x-heroicon-s-pencil-alt class="-ml-1 mr-3 h-5 w-5"/>
                                Edit User
                            </a>

                            @if($user->id !== Auth::id() && !$user->trashed())
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()"
                                    wire:click="deleteUser">
                                    <x-heroicon-s-trash class="-ml-1 mr-3 h-5 w-5"/>
                                    Delete User
                                </button>
                            @endif

                            @if($user->trashed())
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="confirm('Are you sure you want to restore this user?') || event.stopImmediatePropagation()"
                                    wire:click="restoreUser">
                                    <i class="fas fa-undo -ml-1 mr-3"></i>
                                    Restore Account
                                </button>
                            @endif
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
