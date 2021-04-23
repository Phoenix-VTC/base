{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('title', 'Submit New Job')

<div>
    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <x-input.radio-group legend="Game" :error="$errors->first('game')">
                        @foreach($games as $key => $game)
                            <x-input.radio :id="'game_' . strtolower($game[0])" wire:model.lazy="game" :value="$key"
                                           :label="$game[1]"/>
                        @endforeach
                    </x-input.radio-group>

                    <x-input.group label="Pickup City" :error="$errors->first('pickup_city')" col-span="3">
                        <x-input.searchable-select
                            :data="$cities" wire:model="pickup_city" limit="20"
                            placeholder="Select a city"/>
                    </x-input.group>

                    <x-input.group label="Destination City" :error="$errors->first('destination_city')" col-span="3">
                        <x-input.searchable-select
                            :data="$cities" wire:model="destination_city" limit="20"
                            placeholder="Select a city"/>
                    </x-input.group>

                    <x-input.group label="Pickup Company" :error="$errors->first('pickup_company')" col-span="3">
                        <x-input.searchable-select
                            :data="$companies" wire:model="pickup_company" limit="20"
                            placeholder="Select a company"/>
                    </x-input.group>

                    <x-input.group label="Destination Company" :error="$errors->first('destination_company')" col-span="3">
                        <x-input.searchable-select
                            :data="$companies" wire:model="destination_company" limit="20"
                            placeholder="Select a company"/>
                    </x-input.group>

                    <x-input.group label="Cargo" :error="$errors->first('cargo')" col-span="3">
                        <x-input.searchable-select
                            :data="$cargos" wire:model="cargo" limit="20"
                            placeholder="Select a cargo"/>
                    </x-input.group>

                    <br>

                    <x-input.group label="Completed At" for="finished_at" :error="$errors->first('finished_at')"
                                   col-span="3">
                        <x-input.date id="finished_at" wire:model.lazy="finished_at"
                                      :error="$errors->first('finished_at')"
                                      :options="[
                                        'enableTime' => false,
                                        'altFormat' =>  'd/m/Y',
                                        'minDate' => date('Y-m-d', strtotime('-7 days')),
                                        'maxDate' => now()
                                      ]"
                                      trailing-icon="o-calendar"/>
                    </x-input.group>

                    <br>

                    <x-input.group label="Distance" for="distance" :error="$errors->first('distance')" col-span="3"
                                   help-text="Kilometres for ETS, miles for ATS">
                        <x-input.text wire:model.lazy="distance" type="number" id="distance" min="1"
                                      leading-icon="o-location-marker"
                                      :error="$errors->first('distance')" placeholder="1200"/>
                    </x-input.group>

                    <br>

                    <x-input.group label="Cargo Damage" for="load_damage" :error="$errors->first('load_damage')"
                                   col-span="3">
                        <x-input.text wire:model.lazy="load_damage" type="number" id="load_damage" min="0" max="100"
                                      leading-icon="o-shield-exclamation"
                                      :error="$errors->first('load_damage')" placeholder="A value between 0 and 100%"/>
                    </x-input.group>

                    <br>

                    <x-input.group label="Estimated Income" for="estimated_income"
                                   :error="$errors->first('estimated_income')"
                                   col-span="3">
                        <x-input.text wire:model.lazy="estimated_income" type="number" id="estimated_income" min="1"
                                      leading-icon="o-calculator"
                                      :error="$errors->first('estimated_income')"
                                      placeholder="The original estimate, before any penalties"/>
                    </x-input.group>

                    <x-input.group label="Total Income" for="total_income" :error="$errors->first('total_income')"
                                   col-span="3">
                        <x-input.text wire:model.lazy="total_income" type="number" id="total_income" min="1"
                                      :max="$estimated_income"
                                      leading-icon="o-currency-euro"
                                      :error="$errors->first('total_income')"
                                      placeholder="Including any in-game penalties"/>
                    </x-input.group>

                    <x-input.group label="Additional Comments" for="comments" :error="$errors->first('comments')">
                        <x-input.textarea wire:model.lazy="comments" id="comments" rows="3"
                                          :error="$errors->first('comments')"
                                          placeholder="Any notes and/or comments about this delivery"/>
                    </x-input.group>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('jobs.overview') }}"
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
