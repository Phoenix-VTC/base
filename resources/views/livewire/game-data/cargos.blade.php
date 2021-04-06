{{-- The whole world belongs to you --}}

@section('title', 'Manage Cargos')

<div>
    <livewire:game-data.cargos.datatable/>

    <x-page-divider title="Create New Cargo"/>

    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        @csrf

                        <x-input.group label="Name" for="name" :error="$errors->first('name')">
                            <x-input.text wire:model.lazy="name" type="text" id="name"
                                          :error="$errors->first('name')" autocomplete="off"/>
                        </x-input.group>

                        <x-input.group label="DLC" for="dlc" :error="$errors->first('dlc')" col-span="3">
                            <x-input.text wire:model.lazy="dlc" type="text" id="dlc"
                                          :error="$errors->first('dlc')"/>
                        </x-input.group>

                        <x-input.group label="Mod" for="mod" :error="$errors->first('mod')" col-span="3">
                            <x-input.text wire:model.lazy="mod" type="text" id="mod"
                                          :error="$errors->first('mod')"/>
                        </x-input.group>

                        <x-input.group label="Weight" for="weight" :error="$errors->first('weight')"
                                       help-text="Tonnes (t) for ETS2, pounds (lb) for ATS." col-span="3">
                            <x-input.text wire:model.lazy="weight" type="number" id="weight"
                                          :error="$errors->first('weight')" min="1" autocomplete="off"/>
                        </x-input.group>

                        <x-input.group label="Game" for="game_id" :error="$errors->first('game_id')">
                            <x-input.select wire:model.lazy="game_id" id="game_id">
                                <option value="1">Euro Truck Simulator 2</option>
                                <option value="2">American Truck Simulator</option>
                            </x-input.select>
                        </x-input.group>

                        <x-input.radio-group legend="World of Trucks Only" :error="$errors->first('wot')">
                            <x-input.radio id="wot" wire:model.lazy="wot" value="1"
                                           label="Yes"/>

                            <x-input.radio id="wot" wire:model.lazy="wot" value="0"
                                           label="No"/>
                        </x-input.radio-group>
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
