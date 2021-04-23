{{-- The best athlete wants his opponent at his best. --}}

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
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Preferences</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Customize your PhoenixBase to be perfect.
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-12 gap-6">
                        <div class="col-span-full">
                            <x-input.radio-group legend="Preferred Distance Unit"
                                                 :error="$errors->first('preferred_distance')">
                                <x-input.radio
                                    wire:model.lazy="preferred_distance"
                                    id="preferred_distance_kilometres"
                                    value="kilometres"
                                    label="Kilometres"/>

                                <x-input.radio
                                    wire:model.lazy="preferred_distance"
                                    id="preferred_distance_miles"
                                    value="miles"
                                    label="Miles"/>
                            </x-input.radio-group>
                        </div>

                        <div class="col-span-full">
                            <x-input.radio-group legend="Preferred Currency" :error="$errors->first('preferred_currency')">
                                <x-input.radio
                                    wire:model.lazy="preferred_currency"
                                    id="preferred_currency_euro"
                                    value="euro"
                                    label="Euros"/>

                                <x-input.radio
                                    wire:model.lazy="preferred_currency"
                                    id="preferred_currency_dollar"
                                    value="dollar"
                                    label="Dollars"/>
                            </x-input.radio-group>
                        </div>

                        <div class="col-span-full">
                            <x-input.radio-group legend="Preferred Weight Unit"
                                                 :error="$errors->first('preferred_weight')">
                                <x-input.radio
                                    wire:model.lazy="preferred_weight"
                                    id="preferred_weight_tonnes"
                                    value="tonnes"
                                    label="Tonnes"/>

                                <x-input.radio
                                    wire:model.lazy="preferred_weight"
                                    id="preferred_weight_pounds"
                                    value="pounds"
                                    label="Pounds"/>
                            </x-input.radio-group>
                        </div>
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

