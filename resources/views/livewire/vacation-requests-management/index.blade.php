@section('title', 'Manage Vacation Requests')

<div class="mt-5">
    <x-alert/>

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
                                            @empty($vacation_request->handled_by)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Unclaimed
                                                </span>
                                            @elseif($vacation_request->deleted_at)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Cancelled
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
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                            <div class="relative inline-block text-left"
                                                 x-data="{ openRowActions: false }">
                                                <div>
                                                    <button @click="openRowActions = !openRowActions"
                                                            class="rounded-full flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-600"
                                                            id="options-menu" aria-haspopup="true" aria-expanded="true"
                                                            type="button">
                                                        <span class="sr-only">Open options</span>
                                                        {{-- dots-vertical --}}
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                                        </svg>
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
                                                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200">
                                                    <div class="py-1" role="menu" aria-orientation="vertical"
                                                         aria-labelledby="options-menu">
                                                        <a @if(!$vacation_request->handled_by) wire:click="markAsSeen({{ $vacation_request->id }})"
                                                           @endif
                                                           class="group flex items-center px-4 py-2 text-sm text-gray-700 @if($vacation_request->handled_by) cursor-not-allowed @endif hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                                           role="menuitem">
                                                            {{-- eye --}}
                                                            <svg
                                                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                            Mark as seen
                                                        </a>
                                                    </div>

                                                    <div class="py-1">
                                                        <a @if(!$vacation_request->isExpired && !$vacation_request->deleted_at) wire:click="cancel({{ $vacation_request->id }})"
                                                           @endif
                                                           class="group flex items-center px-4 py-2 text-sm text-gray-700 @if($vacation_request->isExpired || $vacation_request->deleted_at) cursor-not-allowed @endif hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                                           role="menuitem">
                                                            {{-- trash --}}
                                                            <svg
                                                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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

                    <x-page-divider title="Vacation Calendar"/>

                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <livewire:vacation-requests-management.calendar
                            :day-click-enabled="false"
                            :drag-and-drop-enabled="false"
                            week-starts-at="1"
                            before-calendar-view="livewire/components/calendar-header"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
