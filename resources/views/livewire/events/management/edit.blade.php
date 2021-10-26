{{-- Close your eyes. Count to one. That is how long forever feels. --}}

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
          integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
          crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
            integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        function uploadEventImage(attachment) {
            @this.upload(
                'images',
                attachment.file,
                function (uploadedURL) {
                    const trixUploadCompletedEvent = `trix-upload-completed:${btoa(uploadedURL)}`;

                    const trixUploadCompletedListener = function(event) {
                        attachment.setAttributes(event.detail);
                        window.removeEventListener(trixUploadCompletedEvent, trixUploadCompletedListener);
                    }

                    window.addEventListener(trixUploadCompletedEvent, trixUploadCompletedListener);

                @this.call('completeImageUpload', uploadedURL, trixUploadCompletedEvent);
                },

                function() {},

                function(event){
                    attachment.setUploadProgress(event.detail.progress);
                }
            )
        }
    </script>

    <style>
        trix-toolbar .trix-button-group--file-tools {
            display: none;
        }
    </style>
@endpush

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

    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <input wire:model.lazy="tmp_event_id" type="hidden"/>

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
                                      :error="$errors->first('map_image_url')"
                                      placeholder="https://i.imgur.com/vJOyb72.png"/>

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
                        <x-input.rich-text wire:model.lazy="description" id="description" @trix-attachment-add="uploadEventImage($event.attachment)" :initial-value="$description"/>
                    </x-input.group>

                    @if($event->tmp_description ?? null)
                        <x-input.group col-span="6" label="TruckersMP Event Description">
                            <div
                                class="shadow-sm block w-full p-2 sm:text-sm border border-gray-300 bg-gray-200 rounded-md prose lg:prose-xl max-w-none">
                                {!! $event->tmp_description !!}
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

                    <x-input.group label="Departure Date and Time (UTC)" for="start_date" :error="$errors->first('start_date')" helpText="Current UTC date & time: <b>{{ Carbon\Carbon::now('UTC') }}</b>">
                        <x-input.date id="start_date" wire:model.lazy="start_date" :error="$errors->first('start_date')"
                                      trailing-icon="o-calendar"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Distance" for="distance"
                                   :error="$errors->first('distance')">
                        <x-input.text wire:model.lazy="distance" type="number" id="distance"
                                      :error="$errors->first('distance')" min="0" placeholder="1200"/>
                    </x-input.group>

                    <x-input.group col-span="3" label="Event XP" for="points"
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

                    <x-input.group col-span="3" label="Event Host" for="hosted_by" :error="$errors->first('hosted_by')">
                        <x-input.select id="hosted_by" wire:model.lazy="hosted_by" placeholder="Choose a host/lead">
                            @foreach($manage_event_users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.radio-group legend="Publish Event" :error="$errors->first('published')">
                        <x-input.radio id="published" wire:model.lazy="published" value="1"
                                       label="Yes"/>

                        <x-input.radio id="published" wire:model.lazy="published" value="0"
                                       label="No"/>
                    </x-input.radio-group>
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
