{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
          integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
          crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
            integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
            crossorigin="anonymous"></script>
@endpush

@section('title', 'New Event')

@section('custom-title')
    <div class="pb-5 border-b border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-900">
            Edit Event
        </h3>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">
            {{ $event->name }}
        </p>
    </div>
@endsection

<div>
    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="col-span-6 sm:col-span-4">
                        <label for="tmp_event_url" class="block text-sm font-medium text-gray-700">
                            TruckersMP Event URL
                        </label>
                        <input wire:model.lazy="tmp_event_url" type="text" name="tmp_event_url" id="tmp_event_url"
                               placeholder="https://truckersmp.com/events/123-event-name"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @error('tmp_event_url') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        <input type="hidden" id="tmp_event_id" name="tmp_event_id" wire:model.lazy="tmp_event_id"/>
                        @if(!$tmp_event_url && !$this->event->tmp_event_id)
                            <p class="mt-2 text-sm text-gray-500">
                                Optional, leave empty if there is no TruckersMP Event.
                            </p>
                        @endif
                        @if($this->event->tmp_event_id && !$tmp_event_url)
                            <p class="mt-2 text-sm text-gray-500">
                                Current Event ID: <b>{{ $this->event->tmp_event_id }}</b>
                                <br>
                                Current Event Name: <b>{{ $this->event->truckersmp_event_data['response']['name'] }}</b>
                            </p>
                        @endif
                        @if(!$tmp_event_id && $tmp_event_url)
                            <p class="mt-2 text-sm text-red-600">
                                Could not find TruckersMP Event ID.
                            </p>
                        @endif
                        @if($tmp_event_id)
                            <p class="mt-2 text-sm text-gray-500">
                                TruckersMP Event ID: {{ $tmp_event_id }}
                            </p>
                        @endif
                        @error('tmp_event_url')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Event Name
                        </label>
                        <input wire:model.lazy="name" type="text" name="name" id="name"
                               placeholder="Kenji's Weekly Drive"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('name')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="featured_image_url" class="block text-sm font-medium text-gray-700">
                            Featured Image URL {{ $this->form_data_changed }}
                        </label>
                        <input wire:model.lazy="featured_image_url" type="text" name="featured_image_url"
                               id="featured_image_url"
                               placeholder="https://i.imgur.com/Uv6fmAq.png"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('featured_image_url') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @if($featured_image_url && !$errors->has('featured_image_url'))
                            <p class="flex mt-2 text-sm items-center text-gray-500">
                                View image
                                <a target="_blank" href="{{ $featured_image_url }}">
                                    {{-- external-link --}}
                                    <svg class="h-4 w-4 ml-1 text-orange-600" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </p>
                        @endif
                        @error('featured_image_url')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="map_image_url"
                               class="block text-sm font-medium text-gray-700">
                            Map Image URL
                        </label>
                        <input wire:model.lazy="map_image_url" type="text" name="map_image_url" id="map_image_url"
                               placeholder="https://i.imgur.com/vJOyb72.png"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('map_image_url') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @if($map_image_url && !$errors->has('map_image_url'))
                            <p class="flex mt-2 text-sm items-center text-gray-500">
                                View image
                                <a target="_blank" href="{{ $map_image_url }}">
                                    {{-- external-link --}}
                                    <svg class="h-4 w-4 ml-1 text-orange-600" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </p>
                        @endif
                        @error('map_image_url')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6">
                        <label for="description" class="mb-1 block text-sm font-medium text-gray-700">
                            Description
                        </label>
                        <x-input.rich-text wire:model.lazy="description" id="description"
                                           :initialValue="$this->event->description"/>
                        @error('description')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($tmp_event_description ?? null)
                        <div class="col-span-6">
                            <label for="description" class="mb-1 block text-sm font-medium text-gray-700">
                                TruckersMP Event Description
                            </label>
                            <div
                                class="shadow-sm block w-full p-2 sm:text-sm border border-gray-300 bg-gray-200 rounded-md prose lg:prose-xl">
                                {!! $tmp_event_description !!}
                            </div>
                        </div>
                    @endif

                    <div class="col-span-6 sm:col-span-4">
                        <label for="server" class="block text-sm font-medium text-gray-700">
                            Server
                        </label>
                        <input wire:model.lazy="server" type="text" name="server" id="server"
                               placeholder="Simulation 1"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif @error('server') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('server')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="required_dlcs" class="block text-sm font-medium text-gray-700">
                            Required DLCs
                        </label>
                        <input wire:model.lazy="required_dlcs" type="text" name="required_dlcs" id="required_dlcs"
                               placeholder="Iberia, Road to the Black Sea"
                               @if($this->tmp_event_data['response'] ?? null) disabled @endif
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif @error('required_dlcs') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @if(!$required_dlcs)
                            <p class="mt-2 text-sm text-gray-500">
                                Optional, leave empty if the event is hosted in a base-game area.
                            </p>
                        @endif
                        @error('required_dlcs')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="departure_location" class="block text-sm font-medium text-gray-700">
                            Departure Location
                        </label>
                        <input wire:model.lazy="departure_location" type="text" name="departure_location"
                               id="departure_location"
                               placeholder="Kaarfor, Amsterdam" @if($this->tmp_event_data['response'] ?? null) disabled
                               @endif
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif @error('departure_location') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('departure_location')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="arrival_location" class="block text-sm font-medium text-gray-700">
                            Arrival Location
                        </label>
                        <input wire:model.lazy="arrival_location" type="text" name="arrival_location"
                               id="arrival_location"
                               placeholder="EuroAcres, Groningen"
                               @if($this->tmp_event_data['response'] ?? null) disabled
                               @endif
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif @error('arrival_location') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('arrival_location')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            Start Date and Time
                        </label>
                        <input type="datetime-local" name="start_date" id="start_date"
                               wire:model.lazy="start_date" @if($this->tmp_event_data['response'] ?? null) disabled
                               @endif
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif @error('start_date') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('start_date')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="distance" class="block text-sm font-medium text-gray-700">
                            Distance
                        </label>
                        <input wire:model.lazy="distance" type="number" name="distance"
                               id="distance"
                               placeholder="1200"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @error('distance') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        <p class="mt-2 text-sm text-gray-500">
                            Optional, leave empty if the distance is unknown.
                        </p>
                        @error('distance')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="points" class="block text-sm font-medium text-gray-700">
                            Event Points
                        </label>
                        <input wire:model.lazy="points" type="number" min="1" name="points"
                               id="points"
                               placeholder="1200"
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md @error('points') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        @error('points')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <fieldset class="col-span-6 sm:col-span-4">
                        <div>
                            <legend class="block text-sm font-medium text-gray-700">
                                Game
                            </legend>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input wire:model.lazy="game_id" id="game_ets2" name="game" type="radio" value="1"
                                       @if($this->tmp_event_data['response'] ?? null) disabled @endif
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300 @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif">
                                <label for="game_ets2" class="ml-3 block text-sm font-medium text-gray-700">
                                    Euro Truck Simulator 2
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input wire:model.lazy="game_id" id="game_ats" name="game" type="radio" value="2"
                                       @if($this->tmp_event_data['response'] ?? null) disabled @endif
                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300 @if($this->tmp_event_data['response'] ?? null) bg-gray-200 @endif">
                                <label for="game_ats" class="ml-3 block text-sm font-medium text-gray-700">
                                    American Truck Simulator
                                </label>
                            </div>
                            @error('game')
                            <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="col-span-6 sm:col-span-3">
                        <div>
                            <legend class="block text-sm font-medium text-gray-700">
                                Extra Options
                            </legend>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-start">
                                <div class="h-5 flex items-center">
                                    <input wire:model.lazy="featured" id="featured" name="featured" type="checkbox"
                                           class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="featured" class="font-medium text-gray-700">Feature this event</label>
                                    <p class="text-gray-500">
                                        Display the event on the top of the events page.
                                    </p>
                                    @error('featured')
                                    <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="h-5 flex items-center">
                                    <input wire:model.lazy="external_event" id="external_event" name="external_event"
                                           type="checkbox"
                                           class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="external_event" class="font-medium text-gray-700">External event</label>
                                    <p class="text-gray-500">
                                        This event isn't hosted by Phoenix
                                    </p>
                                    @error('external_event')
                                    <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="h-5 flex items-center">
                                    <input wire:model.lazy="public_event" id="public_event" name="public_event"
                                           type="checkbox"
                                           class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="public_event" class="font-medium text-gray-700">Public event</label>
                                    <p class="text-gray-500">
                                        Will be displayed on the public events page.
                                    </p>
                                    @error('public_event')
                                    <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <fieldset class="col-span-6 sm:col-span-4">
                                <div>
                                    <legend class="block text-sm font-medium text-gray-700">
                                        Publish Event
                                    </legend>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center">
                                        <input wire:model.lazy="published" id="published_yes" name="published"
                                               type="radio" value="1"
                                               class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                        <label for="published_yes" class="ml-3 block text-sm font-medium text-gray-700">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input wire:model.lazy="published" id="published_no" name="published"
                                               type="radio" value="0"
                                               class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                        <label for="published_no" class="ml-3 block text-sm font-medium text-gray-700">
                                            No
                                        </label>
                                    </div>
                                    @error('published')
                                    <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </fieldset>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mt-12">
                                    Delete Event
                                </label>
                                <button wire:click="delete" type="button"
                                        class="inline-flex mt-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange active:bg-orange-700">
                                    <x-heroicon-o-trash class="mr-2 w-5 h-5"/>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('event-management.index') }}"
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>
