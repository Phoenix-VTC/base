{{-- Be like water. --}}

@section('title', 'Events Management')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('event-management.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create new event
        </a>
    </div>
@endsection

<div>
    <x-alert/>

    <div class="mt-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    {{-- Upcoming Events Table --}}
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        @empty(!$upcoming_events->count())
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hosted By
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($upcoming_events as $event)
                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $event->name }}
                                            @if(!$event->published)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Unpublished
                                                </span>
                                            @endif
                                            @if($event->featured)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                    Featured
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $event->host->username }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $event->start_date->format('d M H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('event-management.attendee-management', $event->id) }}"
                                               class="text-indigo-600 hover:text-indigo-900 mr-4">Manage Attendees</a>
                                            <a href="{{ route('event-management.edit', $event) }}"
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <x-empty-state :image="asset('img/illustrations/events.svg')"
                                           alt="Events illustration">
                                All events will show up here.
                            </x-empty-state>
                        @endempty
                        {{ $upcoming_events->links() }}
                    </div>

                    <x-page-divider title="Calendar"/>

                    {{-- Events Calendar --}}
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <livewire:events.components.events-calendar
                            :day-click-enabled="false"
                            :drag-and-drop-enabled="false"
                            before-calendar-view="livewire/events/components/events-calendar-header"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

