{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', 'Submit a new screenshot')

<div>
    <x-alert/>

    <div class="rounded-md bg-blue-200 p-4 m-4 w-full" wire:loading wire:target="screenshot, submit">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-heroicon-o-information-circle class="h-5 w-5 text-blue-500"/>
            </div>
            <div class="ml-3 text-blue-800">
                <h3 class="mb-2 text-sm font-bold">
                    Please wait
                </h3>
                <p class="text-sm font-medium">
                    Your files are being uploaded.
                </p>
            </div>
        </div>
    </div>

    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <x-input.group label="Title" for="title" :error="$errors->first('title')">
                        <x-input.text wire:model.lazy="title" type="text" id="title" autocomplete="off" required
                                      :error="$errors->first('title')" placeholder="My awesome truck" maxlength="30"/>
                    </x-input.group>

                    <x-input.group label="Screenshot (max 2MB)" for="screenshot"
                                   :error="$errors->first('screenshot')">
                        <x-input.text wire:model.lazy="screenshot" type="file" id="screenshot"
                                      accept=".jpg,.jpeg,.png" required
                                      :error="$errors->first('screenshot')"/>

                        @if($screenshot)
                            <div class="mt-3 block w-full h-full rounded-lg overflow-hidden">
                                <img src="{{ $screenshot->temporaryUrl() }}" alt="Your screenshot" class="object-cover">
                            </div>
                        @endif
                    </x-input.group>

                    <x-input.group label="Description" for="description"
                                   :error="$errors->first('description')" x-data="{descriptionCount: 0}"
                                   x-init="descriptionCount = $refs.description.value.length">
                        <x-input.textarea wire:model.lazy="description" type="text" id="name" rows="3" maxlength="100"
                                          x-ref="description"
                                          x-on:keyup="descriptionCount = $refs.description.value.length"
                                          :error="$errors->first('description')"
                                          placeholder="A small, optional description that describes or provides information about your screenshot.&#13;&#10;Max 100 characters."/>

                        <p class="mt-2 text-sm text-gray-500" x-show.transition.in.out="descriptionCount > 0" x-cloak>
                            <span x-html="descriptionCount"></span> {{ __('slugs.characters') }}
                        </p>
                    </x-input.group>

                    <x-input.group label="Location" for="location" :error="$errors->first('location')">
                        <x-input.text wire:model.lazy="location" type="text" id="location" autocomplete="off"
                                      :error="$errors->first('location')" placeholder="Where the picture was taken, optional" maxlength="30"/>
                    </x-input.group>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('screenshot-hub.index') }}"
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
