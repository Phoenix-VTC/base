{{-- The whole world belongs to you --}}

@section('title', 'Manage Cities')

<div>
    <livewire:game-data.cities.datatable/>

    <x-page-divider title="Add New City"/>

    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        @csrf

                        <x-input.group label="Real Name" for="real_name" :error="$errors->first('real_name')"
                                       help-text="Example: Frankfurt am Main" col-span="3">
                            <x-input.text wire:model.lazy="real_name" type="text" id="real_name"
                                          :error="$errors->first('real_name')" autocomplete="off"/>
                        </x-input.group>

                        <x-input.group label="Name" for="name" :error="$errors->first('name')"
                                       help-text="Example: frankfurt_am_main" col-span="3">
                            <x-input.text wire:model.lazy="name" type="text" id="name"
                                          :error="$errors->first('name')" autocomplete="off"/>
                        </x-input.group>

                        <x-input.group label="Country or US State" for="country" :error="$errors->first('country')">
                            <x-input.text wire:model.lazy="country" type="text" id="country"
                                          :error="$errors->first('country')"/>
                        </x-input.group>

                        <x-input.group label="DLC" for="dlc" :error="$errors->first('dlc')" col-span="3">
                            <x-input.text wire:model.lazy="dlc" type="text" id="dlc"
                                          :error="$errors->first('dlc')"/>
                        </x-input.group>

                        <x-input.group label="Mod" for="mod" :error="$errors->first('mod')" col-span="3">
                            <x-input.text wire:model.lazy="mod" type="text" id="mod"
                                          :error="$errors->first('mod')"/>
                        </x-input.group>

                        <x-input.group label="Game" for="game_id" :error="$errors->first('game_id')">
                            <x-input.select wire:model.lazy="game_id" id="game_id">
                                <option value="1">Euro Truck Simulator 2</option>
                                <option value="2">American Truck Simulator</option>
                            </x-input.select>
                        </x-input.group>

                        <br>

                        <x-input.group label="X-Coordinate" for="x" :error="$errors->first('x')" col-span="2" help-text="Optional, but please try to specify.">
                            <x-input.text wire:model.lazy="x" type="number" id="x"
                                          :error="$errors->first('x')" min="1" autocomplete="off"/>
                        </x-input.group>

                        <x-input.group label="Z-Coordinate" for="z" :error="$errors->first('z')" col-span="2" help-text="Optional, but please try to specify.">
                            <x-input.text wire:model.lazy="z" type="number" id="z"
                                          :error="$errors->first('z')" min="1" autocomplete="off"/>
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
