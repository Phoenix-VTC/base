{{-- Success is as dangerous as failure. --}}

@section('title', 'Request Game Data')

@section('description')
    Missing something in our database? Request it here!
    <br>
    Please make sure that the city, company or cargo doesn't exist yet, and that all the information is correct.
@endsection

<div>
    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        @csrf

                        <x-input.group label="Type" for="type" :error="$errors->first('type')" col-span="3">
                            <x-input.select wire:model.lazy="type" id="type" placeholder="Please choose a type">
                                <option value="city">City</option>
                                <option value="company">Company</option>
                                <option value="cargo">Cargo</option>
                            </x-input.select>
                        </x-input.group>

                        @if($type)
                            <x-input.group label="Game" for="game_id" :error="$errors->first('game_id')" col-span="3">
                                <x-input.select wire:model.lazy="game_id" id="game_id"
                                                placeholder="Please choose a game">
                                    <option value="1">Euro Truck Simulator 2</option>
                                    <option value="2">American Truck Simulator</option>
                                </x-input.select>
                            </x-input.group>

                            <x-input.group label="Name" for="real_name" :error="$errors->first('real_name')"
                                           col-span="3">
                                <x-input.text wire:model.lazy="real_name" type="text" id="real_name"
                                              :error="$errors->first('real_name')" placeholder="MiniMarket"
                                              autocomplete="off"/>
                            </x-input.group>

                            @if($type === 'company')
                                <br>

                                <x-input.group label="Category" for="category" :error="$errors->first('category')"
                                               col-span="3">
                                    <x-input.text wire:model.lazy="category" type="text" id="category"
                                                  :error="$errors->first('category')"
                                                  placeholder="Supermarkets and stores"/>
                                </x-input.group>

                                <x-input.group label="Specialization" for="specialization"
                                               :error="$errors->first('specialization')" col-span="3">
                                    <x-input.text wire:model.lazy="specialization" type="text" id="specialization"
                                                  :error="$errors->first('specialization')"
                                                  placeholder="Supermarket chain"/>
                                </x-input.group>
                            @endif

                            @if($type === 'city')
                                <x-input.group label="Country or US State" for="country"
                                               :error="$errors->first('country')">
                                    <x-input.text wire:model.lazy="country" type="text" id="country"
                                                  :error="$errors->first('country')" placeholder="Germany"/>
                                </x-input.group>
                            @endif

                            @if($type === 'cargo')
                                <br>
                            @endif

                            <x-input.group label="DLC (optional)" for="dlc" :error="$errors->first('dlc')"
                                           help-text="If multiple, separate by comma" col-span="3">
                                <x-input.text wire:model.lazy="dlc" type="text" id="dlc"
                                              :error="$errors->first('dlc')"
                                              placeholder="Vive la France!, Road to the Black Sea"/>
                            </x-input.group>

                            <x-input.group label="Mod (optional)" for="mod" :error="$errors->first('mod')" col-span="3">
                                <x-input.text wire:model.lazy="mod" type="text" id="mod"
                                              :error="$errors->first('mod')" placeholder="ProMods"/>
                            </x-input.group>

                            @if($type === 'cargo')
                                <x-input.group label="Weight (optional)" for="weight" :error="$errors->first('weight')"
                                               help-text="Tonnes (t) for ETS2, pounds (lb) for ATS." col-span="3">
                                    <x-input.text wire:model.lazy="weight" type="number" id="weight"
                                                  :error="$errors->first('weight')" min="1" autocomplete="off"
                                                  placeholder="12"/>
                                </x-input.group>

                                <x-input.radio-group legend="World of Trucks Only" :error="$errors->first('wot')">
                                    <x-input.radio id="wot" wire:model.lazy="wot" value="1"
                                                   label="Yes"/>

                                    <x-input.radio id="wot" wire:model.lazy="wot" value="0"
                                                   label="No"/>
                                </x-input.radio-group>
                            @endif

                            @if($type === 'city')
                                <x-input.group label="X-Coordinate" for="x" :error="$errors->first('x')" col-span="3"
                                               help-text="The <b>in-game</b> coordinates.<br> Optional, but please try to specify.">
                                    <x-input.text wire:model.lazy="x" type="number" id="x"
                                                  :error="$errors->first('x')" placeholder="-6333"
                                                  autocomplete="off"/>
                                </x-input.group>

                                <x-input.group label="Z-Coordinate" for="z" :error="$errors->first('z')" col-span="3"
                                               help-text="The <b>in-game</b> coordinates.<br> Optional, but please try to specify.">
                                    <x-input.text wire:model.lazy="z" type="number" id="z"
                                                  :error="$errors->first('z')" placeholder="2532"
                                                  autocomplete="off"/>
                                </x-input.group>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Request
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
