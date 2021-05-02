{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', 'Editing ' . $user->username . '\'s Account')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('users.profile', $user) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-user class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            View Profile
        </a>
    </div>
@endsection

<div>
    <x-alert/>

    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <x-input.group label="Username" for="username" :error="$errors->first('username')" col-span="3">
                        <x-input.text wire:model="username" type="text" id="username" autocomplete="off"
                                      :error="$errors->first('username')" placeholder="Kenji" required/>
                    </x-input.group>

                    <x-input.group label="E-mail" for="email" :error="$errors->first('email')" col-span="3"
                                   help-text="Account activated: <b>{{ (bool)$user->welcome_valid_until ? 'no' : 'yes' }}</b><br><small>*Via the initial welcome e-mail</small>">
                        <x-input.text wire:model="email" type="email" id="email" autocomplete="off"
                                      :error="$errors->first('email')" placeholder="kenji@shiba.inu" required/>
                    </x-input.group>

                    <x-input.group label="Steam ID" for="steam_id" :error="$errors->first('steam_id')" col-span="3"
                                   help-text="For more info, see: <a href='https://steamidfinder.com/' target='_blank'>SteamIDFinder.com</a><br>Needs to be <b>steamID64 (Dec)</b>">
                        <x-input.text wire:model="steam_id" type="number" id="steam_id" autocomplete="off"
                                      :error="$errors->first('steam_id')" placeholder="76561198125147009" required/>
                    </x-input.group>

                    <x-input.group label="TruckersMP ID" for="truckersmp_id" :error="$errors->first('truckersmp_id')"
                                   col-span="3"
                                   help-text="<a href='https://truckersmp.com/user/{{ $user->truckersmp_id }}' target='_blank'>View TruckersMP Account</a>">
                        <x-input.text wire:model="truckersmp_id" type="number" id="truckersmp_id" autocomplete="off"
                                      :error="$errors->first('truckersmp_id')" placeholder="3181778" required/>
                    </x-input.group>

                    <x-input.group label="Date of Birth" for="date_of_birth" :error="$errors->first('date_of_birth')"
                                   col-span="3">
                        <x-input.text wire:model="date_of_birth" type="date" id="date_of_birth" autocomplete="off"
                                      :error="$errors->first('date_of_birth')" placeholder="2020-12-07" required/>
                    </x-input.group>

                    <br>

                    <x-input.group label="Roles" for="user_roles" :error="$errors->first('user_roles')" help-text="<b>Note:</b> Hold down the ctrl/cmd key to select multiple roles.">
                        <x-input.select wire:model.lazy="user_roles" id="user_roles" size="10" multiple required>
                            @foreach($available_roles as $key => $role)
                                <option value="{{ $key }}">{{ ucwords($role) }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('users.profile', $this->user) }}"
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
