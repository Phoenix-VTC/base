{{-- Success is as dangerous as failure. --}}

@section('title', 'Viewing ' . $user->username . '\'s profile')

<div>
    <x-alert/>

    <div
        class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <div class="flex flex-col">
                <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">
                    Most recent jobs
                </h3>
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Game
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        From
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        To
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap">
                                        Submitted At
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recent_jobs as $job)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 text-sm text-gray-500">
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
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ App\Models\Game::getAbbreviationById($job->game_id) ?? 'Unknown Game' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm prose-sm prose text-gray-500">
                                            <a href="{{ route('jobs.show', $job->id) }}">
                                                {{ ucwords($job->pickupCity->real_name ?? 'Unknown City') }}
                                                ({{ ucwords($job->pickupCompany->name ?? 'Unknown Company') }})
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm prose-sm prose text-gray-500">
                                            <a href="{{ route('jobs.show', $job->id) }}">
                                                {{ ucwords($job->destinationCity->real_name ?? 'Unknown City') }}
                                                ({{ ucwords($job->destinationCompany->name ?? 'Unknown Company') }})
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $job->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(!$recent_jobs->count())
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            Aww, this user hasn't submitted any jobs yet..
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if($recent_jobs->count())
                                <div>
                                    <a href="{{ route('users.jobs-overview', $user) }}"
                                       class="block @if(!($recent_jobs->count() % 2 == 0)) bg-gray-50 @else bg-white @endif text-sm font-medium text-gray-500 text-center px-4 py-4 hover:text-gray-700 sm:rounded-b-lg">
                                        View all jobs
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @can('manage users')

                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">
                            Revision history
                        </h3>
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        User ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Field Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Old Value
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        New Value
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Date
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($user->revisionHistoryWithUser as $revision)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 text-sm prose-sm prose text-gray-900 whitespace-nowrap">
                                            @if($revision->user)
                                                <a href="{{ route('users.profile', $revision->user) }}">
                                                    {{ $revision->user->username ?? 'Deleted User' }}
                                                </a>
                                            @else
                                                <span class="font-semibold">System</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $revision->fieldName() ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $revision->oldValue() ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $revision->newValue() ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $revision->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            There is no revision history available yet for this user.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        <div class="space-y-6 lg:col-start-3 lg:col-span-1">
            <section class="lg:col-start-3 lg:col-span-1">
                <div
                    class="items-center justify-center w-full pb-6 mx-auto mt-8 overflow-hidden bg-white rounded-lg shadow-sm md:max-w-sm">
                    <div class="relative h-40">
                        <img class="absolute object-cover w-full h-full"
                             src="{{ $user->profile_banner }}"
                             alt="{{ $user->username }}'s Profile Banner" height="160" width="370">
                    </div>

                    <div
                        class="relative w-24 h-24 mx-auto -my-12 overflow-hidden border-4 border-white rounded-full shadow">
                        <img class="object-cover w-full h-full" src="{{ $user->profile_picture }}"
                             alt="{{ $user->username }}'s Profile Picture" height="96" width="96">
                    </div>

                    <div class="mt-16">
                        <h1 class="text-lg font-semibold text-center">
                            {{ $user->username }}
                        </h1>
                        @if($user->created_at)
                            <p class="text-sm text-center text-gray-600">
                                Member since <b>{{ $user->created_at->toFormattedDateString() }}</b>
                            </p>
                        @endif
                    </div>

                    <div class="flex flex-wrap pt-3 mx-6 mt-3 border-t gap-y-2">
                        @if($user->roles->count())
                            @foreach($user->roles->sortByDesc('level') as $role)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium mr-2" style="background-color: {{ $role->badge_color }}; color: {{ $role->text_color }}">
                                    {{ ucwords($role->name) }}
                                </span>
                            @endforeach
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800 mr-2">
                                This user doesn't have any roles.
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-col pt-3 mx-6 mt-3 space-y-2 border-t">
                        <p class="text-sm font-medium text-gray-800">
                            Achievements unlocked:
                            <span class="font-semibold">{{ $user->unlockedAchievements()->count() }}</span>
                            /
                            {{ Assada\Achievements\Achievement::all()->count() }}
                        </p>
                    </div>

                    <div class="flex flex-col pt-3 mx-6 mt-3 space-y-2 border-t">
                        <span class="relative group flex items-center space-x-2.5">
                            <i class="w-4 text-gray-700 fab fa-steam hover:text-gray-900"></i>
                            <a href="{{ $user->steamPlayerSummary->profileUrl ?? '#' }}" target="_blank"
                               class="text-sm font-medium text-gray-500 truncate group-hover:text-gray-900">
                                {{ $user->steamPlayerSummary->personaName ?? 'Unknown Steam Name' }}
                            </a>
                        </span>

                        <span class="relative group flex items-center space-x-2.5">
                            <i class="w-4 text-gray-700 fas fa-truck hover:text-gray-900"></i>
                            <a href="https://truckersmp.com/user/{{ $user->truckersmp_id }}" target="_blank"
                               class="text-sm font-medium text-gray-500 truncate group-hover:text-gray-900">
                                {{ $user->truckersMpData['name'] ?? 'Unknown TruckersMP Name' }}
                            </a>
                        </span>

                        @if($user->discord)
                            <span class="relative group flex items-center space-x-2.5">
                                <i class="w-4 text-gray-700 fab fa-discord hover:text-gray-900"></i>
                                <button @click="$clipboard('{{ $user->discord['id'] }}')"
                                        class="text-sm font-medium text-gray-500 truncate group-hover:text-gray-900">
                                    {{ $user->discord['nickname'] }}
                                </button>
                            </span>
                        @elseif(Auth::user()->can('manage users'))
                            <span class="relative group flex items-center space-x-2.5">
                                <i class="w-4 text-gray-700 fab fa-discord"></i>
                                <span class="text-sm font-medium text-red-500 truncate">
                                    No Discord account linked
                                </span>
                            </span>
                        @endif
                    </div>
                </div>
            </section>

            <section aria-labelledby="achievements-title" class="lg:col-start-3 lg:col-span-1">
                <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                    <h2 id="achievements-title" class="text-lg font-medium text-gray-900">Unlocked Achievements</h2>

                    <div class="flow-root mt-6">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($user->unlockedAchievements()->take(3) as $achievement)
                                <li class="py-5">
                                    <div class="flex justify-between">
                                        <div class="flex-1 min-w-0">
                                            <span class="text-sm font-semibold text-gray-800 focus:outline-none">
                                                {{ $achievement->details->name }}
                                            </span>
                                        </div>
                                        <time datetime="2021-01-27T16:35"
                                              class="flex-shrink-0 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $achievement->unlocked_at->diffForHumans(['short' => true]) }}
                                        </time>
                                    </div>

                                    <div class="mt-1">
                                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                            {{ $achievement->details->description }}
                                        </p>
                                    </div>
                                </li>
                            @empty
                                <div class="py-5 text-center">
                                    <x-heroicon-o-emoji-sad class="w-12 h-12 mx-auto text-gray-400"/>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No unlocked achievements</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @if($user->id === Auth::id())
                                            Go explore the PhoenixBase! Don't be shy.
                                        @else
                                            This user hasn't unlocked any achievements yet.
                                        @endif
                                    </p>
                                </div>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('users.achievements', $user) }}"
                           class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            View all
                        </a>
                    </div>
                </div>
            </section>

            @can('manage users')
                <section aria-labelledby="staff-actions-title" class="lg:col-start-3 lg:col-span-1">
                    <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                        <h2 id="staff-actions-title" class="text-lg font-medium text-red-700">Staff Actions</h2>

                        <div class="flex flex-col mt-6 space-y-3 justify-stretch">
                            @can('update', $user)
                                <a
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    href="{{ route('users.edit', $user) }}">
                                    <x-heroicon-s-pencil-alt class="w-5 h-5 mr-3 -ml-1"/>
                                    Edit User
                                </a>
                            @endcan

                            @canBeImpersonated($user, $guard = null)
                            <a
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                href="{{ route('impersonate', $user->id) }}">
                                <x-heroicon-s-identification class="w-5 h-5 mr-3 -ml-1"/>
                                Impersonate User
                            </a>
                            @endCanBeImpersonated

                            @if(!$user->trashed() && Auth::user()->can('delete', $user))
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()"
                                    wire:click="deleteUser">
                                    <x-heroicon-s-trash class="w-5 h-5 mr-3 -ml-1"/>
                                    Delete User
                                </button>
                            @endif

                            @if($user->trashed() && Auth::user()->can('restore', $user))
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="confirm('Are you sure you want to restore this user?') || event.stopImmediatePropagation()"
                                    wire:click="restoreUser">
                                    <i class="mr-3 -ml-1 fas fa-undo"></i>
                                    Restore Account
                                </button>
                            @endif

                            @if($user->application && Auth::user()->can('handle driver applications'))
                                <a
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    href="{{ route('recruitment.show', $user->application->uuid) }}">
                                    <x-heroicon-s-inbox class="w-5 h-5 mr-3 -ml-1"/>
                                    View Driver Application
                                </a>
                            @endif
                        </div>
                    </div>
                </section>
            @endcan
        </div>
    </div>
</div>
