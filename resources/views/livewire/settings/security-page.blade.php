{{-- In work, do what you enjoy. --}}

@section('title', 'Settings')

<div>
    <x-alert/>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
            {{-- Added a wire:ignore here, otherwise the sidebar item active state breaks when choosing a radio button. Wot? --}}
            <aside class="py-6 lg:col-span-3" wire:ignore>
                <x-settings.sidebar/>
            </aside>

            <form class="divide-y divide-gray-200 lg:col-span-9" wire:submit.prevent="submit">
                <div class="py-6 px-4 sm:p-6 lg:pb-8">
                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Security Settings</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Change your account password.
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <x-input.group label="Old Password" for="old_password" :error="$errors->first('old_password')"
                                       col-span="3">
                            <x-input.text wire:model.lazy="old_password" type="password" id="old_password"
                                          :error="$errors->first('old_password')" autocomplete="current-password" required/>
                        </x-input.group>

                        <br>

                        <x-input.group label="New Password" for="new_password" :error="$errors->first('new_password')"
                                       col-span="3">
                            <x-input.text wire:model.lazy="new_password" type="password" id="new_password"
                                          :error="$errors->first('new_password')" autocomplete="new-password" required/>
                        </x-input.group>

                        <x-input.group label="Confirm New Password" for="new_password_confirmation" col-span="3">
                            <x-input.text wire:model.lazy="new_password_confirmation" type="password" id="new_password_confirmation"
                                          autocomplete="new-password" required/>
                        </x-input.group>
                    </div>
                </div>
                <div class="mt-4 py-4 px-4 flex justify-end sm:px-6">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
