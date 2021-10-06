{{-- Care about people's approval and you will be their prisoner. --}}

@section('title', "Editing Blocklist Entry #{$blocklist->id}")

<div>
    <x-alert/>

    <div class="md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <x-input.group label="Usernames" for="usernames" :error="$errors->first('usernames')"
                                       col-span="3">
                            <x-input.select2
                                id="usernames"
                                :selected="$usernames"
                                :tags="true"
                                :multiple="true"
                                placeholder="Enter one or more usernames"/>
                        </x-input.group>

                        <x-input.group label="Emails" for="emails" :error="$errors->first('emails')" col-span="3">
                            <x-input.select2
                                id="emails"
                                :selected="$emails"
                                :tags="true"
                                :multiple="true"
                                placeholder="Enter one or more emails"/>
                        </x-input.group>

                        <x-input.group label="Discord IDs" for="discord_ids" :error="$errors->first('discord_ids')"
                                       col-span="3">
                            <x-input.select2
                                id="discord_ids"
                                :selected="$discord_ids"
                                :tags="true"
                                :multiple="true"
                                placeholder="Enter one or more Discord IDs"/>
                        </x-input.group>

                        <x-input.group label="TruckersMP IDs" for="truckersmp_ids"
                                       :error="$errors->first('truckersmp_ids')" col-span="3">
                            <x-input.select2
                                id="truckersmp_ids"
                                :selected="$truckersmp_ids"
                                :tags="true"
                                :multiple="true"
                                placeholder="Enter one or more TruckersMP IDs"/>
                        </x-input.group>

                        <x-input.group label="SteamID64 IDs" for="steam_ids" :error="$errors->first('steam_ids')"
                                       col-span="3">
                            <x-input.select2
                                id="steam_ids"
                                :selected="$steam_ids"
                                :tags="true"
                                :multiple="true"
                                placeholder="Enter one or more Steam IDs"/>
                        </x-input.group>

                        <x-input.group label="PhoenixBase IDs" for="base_ids" :error="$errors->first('base_ids')"
                                       col-span="3">
                            <x-input.select2
                                id="base_ids"
                                :selected="$base_ids"
                                :tags="true"
                                :multiple="true"
                                placeholder="Enter one or more PhoenixBase IDs"/>
                        </x-input.group>

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
