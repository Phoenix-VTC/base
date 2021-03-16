{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
          integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
          crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
            integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
            crossorigin="anonymous"></script>
@endpush

@section('title', 'Edit Event')

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
                    <x-input.group label="TruckersMP Event URL" for="tmp_event_url" :error="$errors->first('tmp_event_url')">
                        <x-input.text wire:model.lazy="tmp_event_url" type="text" id="tmp_event_url"
                                      :error="$errors->first('tmp_event_url')" placeholder="https://truckersmp.com/events/123-event-name"/>

                        <input type="hidden" id="tmp_event_id" name="tmp_event_id" wire:model.lazy="tmp_event_id"/>

                        @if(!$tmp_event_url)
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
                    </x-input.group>

                    <x-input.group label="Event Name" for="name" :error="$errors->first('name')">
                        <x-input.text wire:model.lazy="name" type="text" id="name"
                                      :error="$errors->first('name')" placeholder="Kenji's Weekly Drive"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Featured Image URL" for="featured_image_url"
                                   :error="$errors->first('featured_image_url')">
                        <x-input.text wire:model.lazy="featured_image_url" type="text" id="featured_image_url"
                                      :error="$errors->first('featured_image_url')"
                                      placeholder="https://i.imgur.com/Uv6fmAq.png"/>

                        @if($featured_image_url && !$errors->has('featured_image_url'))
                            <p class="flex mt-2 text-sm items-center text-gray-500">
                                View image
                                <a target="_blank" href="{{ $featured_image_url }}">
                                    <x-heroicon-o-external-link class="h-4 w-4 ml-1 text-orange-600"/>
                                </a>
                            </p>
                        @endif
                    </x-input.group>

                    <x-input.group col-span="3" label="Map Image URL" for="map_image_url"
                                   :error="$errors->first('map_image_url')">
                        <x-input.text wire:model.lazy="map_image_url" type="text" id="map_image_url"
                                      :error="$errors->first('map_image_url')" placeholder="Kenji's Weekly Drive"/>

                        @if($map_image_url && !$errors->has('map_image_url'))
                            <p class="flex mt-2 text-sm items-center text-gray-500">
                                View image
                                <a target="_blank" href="{{ $map_image_url }}">
                                    <x-heroicon-o-external-link class="h-4 w-4 ml-1 text-orange-600"/>
                                </a>
                            </p>
                        @endif
                    </x-input.group>

                    <x-input.group col-span="6" label="Description" for="description">
                        <x-input.rich-text wire:model.lazy="description" id="description" :initial-value="$description"/>
                    </x-input.group>

                    @if($tmp_event_description ?? null)
                        <x-input.group col-span="6" label="TruckersMP Event Description">
                            <div
                                class="shadow-sm block w-full p-2 sm:text-sm border border-gray-300 bg-gray-200 rounded-md prose lg:prose-xl max-w-none">
                                {!! $tmp_event_description !!}
                            </div>
                        </x-input.group>
                    @endif

                    <x-input.group label="Server" for="server" :error="$errors->first('server')">
                        <x-input.text wire:model.lazy="server" type="text" id="server"
                                      :error="$errors->first('server')" placeholder="Simulation 1"/>
                    </x-input.group>

                    <x-input.group label="Required DLCs" for="required_dlcs" :error="$errors->first('required_dlcs')"
                                   help-text="Optional, leave empty if the event is hosted in a base-game area.">
                        <x-input.text wire:model.lazy="required_dlcs" type="text" id="required_dlcs"
                                      :error="$errors->first('required_dlcs')"
                                      placeholder="Iberia, Road to the Black Sea"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Departure Location" for="departure_location"
                                   :error="$errors->first('departure_location')">
                        <x-input.text wire:model.lazy="departure_location" type="text" id="departure_location"
                                      :error="$errors->first('departure_location')" placeholder="Kaarfor, Amsterdam"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Arrival Location" for="arrival_location"
                                   :error="$errors->first('arrival_location')">
                        <x-input.text wire:model.lazy="arrival_location" type="text" id="arrival_location"
                                      :error="$errors->first('arrival_location')" placeholder="EuroAcres, Groningen"/>
                    </x-input.group>

                    <x-input.group label="Start Date and Time" for="start_date" :error="$errors->first('start_date')">
                        <x-input.text wire:model.lazy="start_date" type="datetime-local" id="start_date"
                                      :error="$errors->first('start_date')"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Distance" for="distance"
                                   :error="$errors->first('distance')"
                                   help-text="Optional, leave empty if the distance is unknown.">
                        <x-input.text wire:model.lazy="distance" type="number" id="distance"
                                      :error="$errors->first('distance')" placeholder="1200"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Event Points" for="points"
                                   :error="$errors->first('points')">
                        <x-input.text wire:model.lazy="points" type="number" id="points"
                                      :error="$errors->first('points')" min="100" max="500" step="10"
                                      placeholder="100"/>
                    </x-input.group>

                    <x-input.radio-group legend="Game" :error="$errors->first('game')">
                        <x-input.radio id="game_ets2" wire:model.lazy="game_id" value="1"
                                       label="Euro Truck Simulator 2"/>

                        <x-input.radio id="game_ats" wire:model.lazy="game_id" value="2"
                                       label="American Truck Simulator"/>
                    </x-input.radio-group>

                    <x-input.group label="Extra Options">
                        <div class="mt-4 space-y-4">
                            <x-input.checkbox id="featured" wire:model.lazy="featured" label="Feature this event"
                                              help-text="Display the event on the top of the events page."/>

                            <x-input.checkbox id="external_event" wire:model.lazy="external_event"
                                              label="External event"
                                              help-text="This event isn't hosted by Phoenix."/>

                            <x-input.checkbox id="public_event" wire:model.lazy="public_event" label="Public event"
                                              help-text="For events that non-phoenix members can attend."/>
                        </div>
                    </x-input.group>

                    <x-input.radio-group legend="Publish Event" :error="$errors->first('published')">
                        <x-input.radio id="published" wire:model.lazy="published" value="1"
                                       label="Yes"/>

                        <x-input.radio id="published" wire:model.lazy="published" value="0"
                                       label="No"/>
                    </x-input.radio-group>

                    <x-input.group label="Delete Event">
                        <button wire:click="delete" type="button"
                                class="inline-flex mt-3 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange active:bg-orange-700">
                            <x-heroicon-o-trash class="mr-2 w-5 h-5"/>
                            Delete
                        </button>
                    </x-input.group>
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
