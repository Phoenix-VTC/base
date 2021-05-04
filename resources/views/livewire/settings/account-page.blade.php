{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

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
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Account Settings</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Change your profile and account settings.
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <x-input.group label="Username" for="username" :error="$errors->first('username')" col-span="3">
                            <x-input.text wire:model.lazy="username" type="text" id="username"
                                          :error="$errors->first('username')" autocomplete="username"/>
                        </x-input.group>

                        <x-input.group label="Email" for="email" :error="$errors->first('email')" col-span="3">
                            <x-input.text wire:model.lazy="email" type="email" id="email"
                                          :error="$errors->first('email')" autocomplete="email"/>
                        </x-input.group>

                        <x-input.group label="Steam ID" for="steam_id" col-span="3"
                                       help-text="Contact a staff member in order to change this.<br><a href='https://steamcommunity.com/profiles/{{ $user->steam_id }}' target='_blank'>View Steam Profile</a>">
                            <x-input.text wire:model.lazy="steam_id" type="text" id="steam_id" class="bg-gray-100"
                                          disabled/>
                        </x-input.group>

                        <x-input.group label="TruckersMP ID" for="truckersmp_id" col-span="3"
                                       help-text="Contact a staff member in order to change this.<br><a href='https://truckersmp.com/user/{{ $user->truckersmp_id }}' target='_blank'>View TruckersMP Profile</a>">
                            <x-input.text wire:model.lazy="truckersmp_id" type="text" id="truckersmp_id"
                                          class="bg-gray-100" disabled/>
                        </x-input.group>

                        <x-input.group label="Date of Birth" for="date_of_birth"
                                       col-span="3" help-text="Contact a staff member in order to change this.">
                            <x-input.text wire:model="date_of_birth" type="date" id="date_of_birth" class="bg-gray-100"
                                          disabled/>
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


