{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@section('title', 'Edit Event')

@section('description', $event->name)

@section('actions')
    <div class="ml-3">
        <a href="{{ route('events.show', ['id' => $event->id, 'slug' => $event->slug]) }}" target="_blank"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-link class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            View
        </a>
    </div>

    <div class="ml-3">
        <a href="{{ route('event-management.attendee-management', $event) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-users class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            Manage Attendees
        </a>
    </div>

    <div class="ml-3">
        <a href="{{ route('event-management.revisions', $event) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-search class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            Revision History
        </a>
    </div>

    <form action="{{ route('event-management.delete', $event) }}" method="POST">
        @csrf

        <div class="ml-3">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <x-heroicon-s-trash class="-ml-1 mr-2 h-5 w-5"/>
                Delete Event
            </button>
        </div>
    </form>
@endsection

<div>
    <x-alert/>

    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            {{ $this->form }}

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('event-management.index') }}" color="secondary">
                        Cancel
                    </x-app-ui::button>

                    <x-app-ui::button type="submit">
                        Update
                    </x-app-ui::button>
                </x-app-ui::card.actions>
            </x-slot>
        </x-app-ui::card>
    </form>
</div>
