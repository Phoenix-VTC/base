{{-- Because she competes with no one, no one can compete with her. --}}

@section('title', "Viewing Blocklist Entry #{$blocklist->id}")

<div>
    <x-alert/>

    <div
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <!-- Blocklist Information -->
            <section aria-labelledby="blocklist-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="blocklist-information-title" class="text-lg leading-6 font-medium text-gray-900">
                            Blocklist Information
                        </h2>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            The known information about the blocklisted user
                        </p>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            @if($blocklist->usernames)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Usernames
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($blocklist->usernames)
                                            {{ implode(', ', $blocklist->usernames) }}
                                        @else
                                            none
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if($blocklist->emails)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Emails
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($blocklist->emails)
                                            {{ implode(', ', $blocklist->emails) }}
                                        @else
                                            none
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if($blocklist->discord_ids)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Discord IDs
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($blocklist->discord_ids)
                                            {{ implode(', ', $blocklist->discord_ids) }}
                                        @else
                                            none
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if($blocklist->truckersmp_ids)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        TruckersMP IDs
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 prose prose-sm">
                                        @forelse($blocklist->truckersmp_ids as $truckersmp_id)
                                            <a href="https://truckersmp.com/user/{{ $truckersmp_id }}"
                                               target="_blank">{{ $truckersmp_id }}</a>@if(!$loop->last),@endif
                                        @empty
                                            none
                                        @endforelse
                                    </dd>
                                </div>
                            @endif

                            @if($blocklist->steam_ids)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Steam IDs
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 prose prose-sm">
                                        @forelse($blocklist->steam_ids as $steam_id)
                                            <a href="https://steamcommunity.com/profiles/{{ $steam_id }}"
                                               target="_blank">{{ $steam_id }}</a>@if(!$loop->last),@endif
                                        @empty
                                            none
                                        @endforelse
                                    </dd>
                                </div>
                            @endif

                            @if($blocklist->base_ids)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        PhoenixBase IDs
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 prose prose-sm">
                                        @forelse($blocklist->base_ids as $base_id)
                                            <a href="{{ route('users.profile', $base_id) }}"
                                               target="_blank">{{ $base_id }}</a>@if(!$loop->last),@endif
                                        @empty
                                            none
                                        @endforelse
                                    </dd>
                                </div>
                            @endif

                            <div class="sm:col-span-2">
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">
                                    Reason
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {!! nl2br(e($blocklist->reason)) !!}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>

            <x-info-card title="Revision History">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 -my-7">
                    <div class="py-2 align-middle inline-block min-w-full">
                        <div class="overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Field Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Old Value
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        New Value
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($blocklist->revisionHistoryWithUser as $revision)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 prose prose-sm">
                                            @if($revision->user_id)
                                                <a href="{{ route('users.profile', $revision->user_id) }}">
                                                    {{ $revision->user->username ?? 'Deleted User' }}
                                                </a>
                                            @else
                                                <span class="font-semibold">System</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $revision->fieldName() ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $revision->oldValue() ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $revision->newValue() ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $revision->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            There is no revision history available yet for this blocklist entry.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </x-info-card>
        </div>

        <div class="lg:col-start-3 lg:col-span-1 space-y-6">
            <section aria-labelledby="entry-information-title" class="lg:col-start-3 lg:col-span-1">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="entry-information-title" class="text-lg font-medium text-gray-900">Entry Information</h2>

                    <div class="mt-6 flow-root">
                        <div class="space-y-5">
                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-calendar class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Created at</span>
                                <span class="text-gray-900 text-sm font-bold">
                                    {{ $blocklist->created_at->toDayDateTimeString() }}
                                </span>
                            </div>

                            {{-- Only show updated_at if it's not equal to created_at --}}
                            @if($blocklist->updated_at->ne($blocklist->created_at))
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-s-pencil-alt class="h-5 w-5 text-gray-400"/>
                                    <span class="text-gray-900 text-sm font-medium">Updated at</span>
                                    <span class="text-gray-900 text-sm font-bold">
                                        {{ $blocklist->updated_at->toDayDateTimeString() }}
                                    </span>
                                </div>
                            @endif

                            @if($blocklist->deleted_at)
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-s-trash class="h-5 w-5 text-gray-400"/>
                                    <span class="text-gray-900 text-sm font-medium">Deleted at</span>
                                    <span class="text-gray-900 text-sm font-bold">
                                        {{ $blocklist->deleted_at->toDayDateTimeString() }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center space-x-2">
                                <x-heroicon-s-information-circle class="h-5 w-5 text-gray-400"/>
                                <span class="text-gray-900 text-sm font-medium">Status:</span>
                                @if(!$blocklist->deleted_at)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Deleted (inactive)
                                    </span>
                                @endif
                            </div>

                            <div class="relative">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center"></div>
                            </div>

                            @if($blocklist->firstEditor())
                                <div class="mt-6 flex items-center">
                                    <a class="flex-shrink-0"
                                       href="{{ route('users.profile', $blocklist->firstEditor()->id) }}">
                                        <img class="h-10 w-10 rounded-full"
                                             src="{{ $blocklist->firstEditor()->profile_picture ?? asset('svg/unknown_avatar.svg') }}"
                                             alt="{{ $blocklist->firstEditor()->username ?? 'Deleted User' }}"
                                             height="40" width="40">
                                    </a>
                                    <div class="ml-3">
                                        <div class="flex space-x-1 text-sm text-gray-500">
                                            <span>Created by</span>
                                        </div>
                                        <a class="text-sm font-medium capitalize text-gray-900"
                                           href="{{ route('users.profile', $blocklist->firstEditor()->id) }}">
                                            {{ $blocklist->firstEditor()->username ?? 'Deleted User' }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- Only show updated_at if it's not equal to created_at --}}
                            @if($blocklist->updated_at->ne($blocklist->created_at) && $blocklist->latestEditor())
                                <div class="mt-6 flex items-center">
                                    <a class="flex-shrink-0"
                                       href="{{ route('users.profile', $blocklist->latestEditor()->id) }}">
                                        <img class="h-10 w-10 rounded-full"
                                             src="{{ $blocklist->latestEditor()->profile_picture ?? asset('svg/unknown_avatar.svg') }}"
                                             alt="{{ $blocklist->latestEditor()->username ?? 'Deleted User' }}"
                                             height="40" width="40">
                                    </a>
                                    <div class="ml-3">
                                        <div class="flex space-x-1 text-sm text-gray-500">
                                            <span>Last edit by</span>
                                        </div>
                                        <a class="text-sm font-medium capitalize text-gray-900"
                                           href="{{ route('users.profile', $blocklist->latestEditor()->id) }}">
                                            {{ $blocklist->latestEditor()->username ?? 'Deleted User' }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section aria-labelledby="actions-title" class="lg:col-start-3 lg:col-span-1">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                    <h2 id="actions-title" class="text-lg font-medium text-gray-900">Actions</h2>

                    <div class="mt-6 flex flex-col justify-stretch space-y-3">
                        @if(!$blocklist->deleted_at && Auth::user()->can('create blocklist'))
                            <a class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                               href="{{ route('user-management.blocklist.edit', $blocklist->id) }}">
                                <x-heroicon-s-pencil-alt class="-ml-1 mr-3 h-5 w-5"/>
                                Edit
                            </a>
                        @endif

                        @if(!$blocklist->deleted_at)
                            <button
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                onclick="confirm('Are you sure you want to delete this blocklist?') || event.stopImmediatePropagation()"
                                wire:click="delete">
                                <x-heroicon-s-trash class="-ml-1 mr-3 h-5 w-5"/>
                                Delete
                            </button>
                        @endif

                        @if($blocklist->deleted_at)
                            <button
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                onclick="confirm('Are you sure you want to restore this blocklist?') || event.stopImmediatePropagation()"
                                wire:click="restore">
                                <i class="fas fa-undo -ml-1 mr-3"></i>
                                Restore
                            </button>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
