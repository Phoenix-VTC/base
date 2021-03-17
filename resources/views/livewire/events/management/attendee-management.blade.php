@section('title', "Manage $event->name Attendees")

@section('custom-title')
    <div class="pb-5 border-b border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-900">
            Manage <span class="font-extrabold">{{ $event->name }}</span> Attendees
        </h3>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">
            Add and/or remove attendees, and reward their Event XP after completing the event.
        </p>
    </div>
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
                                        <button type="button"
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
                                   alt="Well Done illustration">
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
        </ul>
    </div>
    <div class="mt-4">
        <button type="button" wire:click="submitRewards"
                class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange active:bg-orange-700">
            Reward Event XP
        </button>
    </div>
</div>

