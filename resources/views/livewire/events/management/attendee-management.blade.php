@section('title', "Manage $event->name Attendees")

@section('description')
    Add and/or remove attendees, and reward their Event XP after completing the event.
@endsection

@section('meta')
    <x-header.meta-item icon="s-users">
        {{ $event->attendees->count() ?? 0 }} {{ \Illuminate\Support\Str::plural('attendee', $event->attendees->count() ?? 0) }}
    </x-header.meta-item>
@endsection

@section('actions')
    <div class="ml-3">
        <a href="{{ route('event-management.edit', $event) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-pencil class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            Edit
        </a>
    </div>

    <div class="ml-3">
        <a href="{{ route('events.show', ['id' => $event->id, 'slug' => $event->slug]) }}" target="_blank"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-link class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            View
        </a>
    </div>

    <form action="{{ route('event-management.reward-event-xp', $event) }}" method="POST">
        @csrf

        <div class="ml-3">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <x-heroicon-s-check class="-ml-1 mr-2 h-5 w-5"/>
                Reward Event XP
            </button>
        </div>
    </form>
@endsection

<div>
    <x-alert/>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @if(!$event->completed)
                @foreach($event->attendees as $attendee)
                    <li>
                        <div class="flex items-center px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full"
                                         src="{{ $attendee->user->profile_picture ?? '' }}"
                                         alt="{{ $attendee->user->username ?? 'Unknown User' }}">
                                </div>
                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-black truncate">{{ $attendee->user->username ?? 'Unknown User' }}</p>
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    @if($attendee->attending->value === App\Enums\Attending::Yes)
                                                        <x-heroicon-s-check-circle
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                                        Attending
                                                    @endif
                                                    @if($attendee->attending->value === App\Enums\Attending::Maybe)
                                                        <x-heroicon-s-question-mark-circle
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                                        Unsure
                                                    @endif
                                                </p>
                                                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                    <x-heroicon-s-calendar
                                                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                                                    Attendance marked on&nbsp;
                                                    <strong>{{ $attendee->updated_at->format('d M H:i') }}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($attendee->attending->value === App\Enums\Attending::Yes)
                                    <button type="button" wire:click="removeAttendance({{ $attendee }})"
                                            class="relative inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        <x-heroicon-o-x class="-ml-1 mr-2 h-5 w-5 text-gray-400"/>
                                        Remove Attendance
                                    </button>
                                @endif
                                @if($attendee->attending->value === App\Enums\Attending::Maybe)
                                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                        <button type="button" wire:click="confirmAttendance({{ $attendee }})"
                                                class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                            <x-heroicon-s-check class="-ml-1 mr-2 h-5 w-5 text-gray-400"/>
                                            Confirm Attendance
                                        </button>
                                        <button type="button" wire:click="removeAttendance({{ $attendee }})"
                                                class="-ml-px relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                            <x-heroicon-o-x class="h-5 w-5 text-gray-400"/>
                                        </button>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
                @empty($event->attendees->count())
                    <x-empty-state :image="asset('img/illustrations/no_data.svg')"
                                   alt="No data illustration">
                        There are no attendees yet for this event.
                    </x-empty-state>
                @endempty
                <li>
                    <form class="flex items-center px-4 py-4 sm:px-6 hover:bg-gray-50"
                          wire:submit.prevent="addAttendee">
                        <div class="min-w-0 flex-1 flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full"></div>
                            </div>
                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <x-input.group for="username" :error="$errors->first('username')"
                                                       label="Add new attendee">
                                            <x-input.text class="h-8 pl-2" id="username" wire:model.lazy="username"
                                                          :error="$errors->first('username')" autocomplete="off"
                                                          placeholder="Username"/>
                                        </x-input.group>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                    class="relative inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-heroicon-o-plus class="-ml-1 mr-2 h-5 w-5 text-gray-400"/>
                                Add Attendee
                            </button>
                        </div>
                    </form>
                </li>
            @else
                <x-empty-state :image="asset('img/illustrations/well_done.svg')"
                               alt="Well Done illustration">
                    This event is already completed, and the XP has already been rewarded.
                </x-empty-state>
            @endif
            @if(!$event->completed && !$event->is_past)
                <h3 class="text-2xl text-center font-semibold text-gray-900 p-3">
                    You'll be able to reward the Event XP after the event has finished.
                </h3>
            @endif
        </ul>
    </div>
</div>

