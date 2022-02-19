@section('title', 'Manage Vacation Requests')

<div class="mt-5">
    <x-alert />

    <div class="mt-5">
        <div class="flex flex-col">
            <div class="-my-2 auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow border-b border-gray-200 sm:rounded-lg">
                        @empty(!$vacation_requests->count())
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Username
                                    </th>
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
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vacation_requests as $vacation_request)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $vacation_request->user->username ?? 'Deleted User' }}
                                            ({{ $vacation_request->user_id }})
                                        </td>
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
                                        <td class="px-6 py-4 flex whitespace-nowrap text-sm text-gray-500">
                                            @isset($vacation_request->handled_by)
                                                {{ $vacation_request->staff->username ?? 'Deleted User' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $vacation_request->getStatus()['color'] }}-100 text-{{ $vacation_request->getStatus()['color'] }}-800">
                                                {{ ucwords($vacation_request->getStatus()['status']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                            @canany(['markAsSeen', 'cancel'], $vacation_request)
                                                <div class="relative inline-block text-left"
                                                     x-data="{ openRowActions: false }">
                                                    <div>
                                                        <button @click="openRowActions = !openRowActions"
                                                                class="rounded-full flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-600"
                                                                id="options-menu" aria-haspopup="true"
                                                                aria-expanded="true"
                                                                type="button">
                                                            <span class="sr-only">Open options</span>
                                                            <x-heroicon-s-dots-vertical class="h-5 w-5" />
                                                        </button>
                                                    </div>

                                                    <div x-show="openRowActions" x-cloak
                                                         @click.away="openRowActions = false"
                                                         x-transition:enter="transition ease-out duration-100"
                                                         x-transition:enter-start="opacity-0 scale-95"
                                                         x-transition:enter-end="opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-75"
                                                         x-transition:leave-start="opacity-100 scale-100"
                                                         x-transition:leave-end="opacity-0 scale-95"
                                                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 z-50">
                                                        @can('markAsSeen', $vacation_request)
                                                            <div class="py-1" role="menu" aria-orientation="vertical"
                                                                 aria-labelledby="options-menu">
                                                                <a wire:click="markAsSeen({{ $vacation_request->id }})"
                                                                   class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                                                   role="menuitem">
                                                                    <x-heroicon-o-eye
                                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                                    Mark as seen
                                                                </a>
                                                            </div>
                                                        @endcan

                                                        @can('cancel', $vacation_request)
                                                            <div class="py-1">
                                                                <a wire:click="cancel({{ $vacation_request->id }})"
                                                                   class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                                                   role="menuitem">
                                                                    <x-heroicon-o-trash
                                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                                    Cancel
                                                                </a>
                                                            </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <x-empty-state :image="asset('img/illustrations/travel_plans.svg')"
                                           alt="Travel plans illustration">
                                This is where you'll see the vacation requests.
                            </x-empty-state>
                        @endempty
                        {{ $vacation_requests->links() }}
                    </div>

                    <x-page-divider title="Vacation Calendar" />

                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <livewire:vacation-requests-management.calendar
                            :day-click-enabled="false"
                            :drag-and-drop-enabled="false"
                            week-starts-at="1"
                            before-calendar-view="livewire/components/calendar-header" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
