{{-- Care about people's approval and you will be their prisoner. --}}

@section('title', 'Add New Blocklist Entry')

<div>
    <x-alert/>

    <div class="md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <x-input.group label="PhoenixBase ID or Driver Application ID" for="base_or_recruitment_id"
                                       :error="$errors->first('base_or_recruitment_id')">
                            <x-input.text wire:model.lazy="base_or_recruitment_id" type="text"
                                          id="base_or_recruitment_id" autocomplete="off"
                                          :error="$errors->first('base_or_recruitment_id')"/>
                            @if(($user || $driverApplication) && $base_or_recruitment_id)
                                <p class="mt-2 text-sm text-gray-500">
                                    Chosen user: <b>{{ $user->username ?? $driverApplication->username }}</b>
                                </p>
                            @endif
                        </x-input.group>
                    </div>

                    @if(!$base_or_recruitment_id)
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-2 bg-white text-gray-500">
                                    Or add manually
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-6 gap-6">
                            <x-input.group label="Usernames" for="usernames" :error="$errors->first('usernames')"
                                           col-span="3">
                                <x-input.select2
                                    id="usernames"
                                    wire:model="usernames"
                                    :tags="true"
                                    :multiple="true"
                                    placeholder="Enter one or more usernames"/>
                            </x-input.group>

                            <x-input.group label="Emails" for="emails" :error="$errors->first('emails')" col-span="3">
                                <x-input.select2
                                    id="emails"
                                    wire:model="emails"
                                    :tags="true"
                                    :multiple="true"
                                    placeholder="Enter one or more emails"/>
                            </x-input.group>

                            <x-input.group label="Discord IDs" for="discord_ids" :error="$errors->first('discord_ids')"
                                           col-span="3">
                                <x-input.select2
                                    id="discord_ids"
                                    wire:model="discord_ids"
                                    :tags="true"
                                    :multiple="true"
                                    placeholder="Enter one or more Discord IDs"/>
                            </x-input.group>

                            <x-input.group label="TruckersMP IDs" for="truckersmp_ids"
                                           :error="$errors->first('truckersmp_ids')" col-span="3">
                                <x-input.select2
                                    id="truckersmp_ids"
                                    wire:model="truckersmp_ids"
                                    :tags="true"
                                    :multiple="true"
                                    placeholder="Enter one or more TruckersMP IDs"/>
                            </x-input.group>

                            <x-input.group label="SteamID64 IDs" for="steam_ids" :error="$errors->first('steam_ids')"
                                           col-span="3">
                                <x-input.select2
                                    id="steam_ids"
                                    wire:model="steam_ids"
                                    :tags="true"
                                    :multiple="true"
                                    placeholder="Enter one or more Steam IDs"/>
                            </x-input.group>

                            <x-input.group label="PhoenixBase IDs" for="base_ids" :error="$errors->first('base_ids')"
                                           col-span="3">
                                <x-input.select2
                                    id="base_ids"
                                    wire:model="base_ids"
                                    :tags="true"
                                    :multiple="true"
                                    placeholder="Enter one or more PhoenixBase IDs"/>
                            </x-input.group>
                        </div>
                    @endif

                    <div class="grid grid-cols-6 mt-6">
                        <x-input.group label="Reason" for="reason" :error="$errors->first('reason')" col-span="4">
                            <x-input.textarea wire:model.lazy="reason" id="reason" rows="3"
                                              :error="$errors->first('reason')"
                                              placeholder="The reason for this blocklist entry"/>
                        </x-input.group>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
