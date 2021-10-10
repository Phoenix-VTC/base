{{-- The Master doesn't talk, he acts. --}}

@section('title', "Verify Job #{$job->id}")

<div>
    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden rounded-xl">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <x-input.group label="Pickup City" :error="$errors->first('pickup_city')" col-span="3">
                            <x-input.select2
                                :url="route('api.game-data.cities', $job->game_id)"
                                id="pickup_city"
                                wire:model="pickup_city"
                                placeholder="Select a city"
                                :selected="[$job->pickup_city_id => $job->pickupCity->real_name]"/>
                        </x-input.group>

                        <x-input.group label="Destination City" :error="$errors->first('destination_city')"
                                       col-span="3">
                            <x-input.select2
                                :url="route('api.game-data.cities', $job->game_id)"
                                id="destination_city"
                                wire:model="destination_city"
                                placeholder="Select a city"
                                :selected="[$job->destination_city_id => $job->destinationCity->real_name]"/>
                        </x-input.group>

                        <x-input.group label="Pickup Company" :error="$errors->first('pickup_company')" col-span="3">
                            <x-input.select2
                                :url="route('api.game-data.companies', $job->game_id)"
                                id="pickup_company"
                                wire:model="pickup_company"
                                placeholder="Select a company"
                                :selected="[$job->pickup_company_id => $job->pickupCompany->name]"/>
                        </x-input.group>

                        <x-input.group label="Destination Company" :error="$errors->first('destination_company')"
                                       col-span="3">
                            <x-input.select2
                                :url="route('api.game-data.companies', $job->game_id)"
                                id="destination_company"
                                wire:model="destination_company"
                                placeholder="Select a company"
                                :selected="[$job->destination_company_id => $job->destinationCompany->name]"/>
                        </x-input.group>

                        <x-input.group label="Cargo" :error="$errors->first('cargo')" col-span="3">
                            <x-input.select2
                                :url="route('api.game-data.cargos', $job->game_id)"
                                id="cargo"
                                wire:model="cargo"
                                placeholder="Select a cargo"
                                :selected="[$job->cargo_id => $job->cargo->name]"/>
                        </x-input.group>

                        <br>

                        <x-input.group label="Finished At" for="finished_at" :error="$errors->first('finished_at')"
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
                            <x-input.text wire:model.lazy="distance" type="number" id="distance" min="1" max="5000"
                                          leading-icon="o-location-marker"
                                          :error="$errors->first('distance')" placeholder="1200"/>
                        </x-input.group>

                        <br>

                        <x-input.group label="Cargo Damage" for="load_damage" :error="$errors->first('load_damage')"
                                       col-span="3">
                            <x-input.text wire:model.lazy="load_damage" type="number" id="load_damage" min="0" max="100"
                                          leading-icon="o-shield-exclamation"
                                          :error="$errors->first('load_damage')"
                                          placeholder="A value between 0 and 100%"/>
                        </x-input.group>

                        <br>

                        <x-input.group label="Estimated Income" for="estimated_income"
                                       col-span="3" help-text="The original estimate, before any penalties">
                            <x-input.text wire:model.lazy="estimated_income" type="number" id="estimated_income"
                                          leading-icon="o-calculator" disabled class="bg-gray-50"/>
                        </x-input.group>

                        <x-input.group label="Total Income" for="total_income" :error="$errors->first('total_income')"
                                       col-span="3" help-text="Including any in-game penalties">
                            <x-input.text wire:model.lazy="total_income" type="number" id="total_income" min="1"
                                          :max="$estimated_income"
                                          leading-icon="o-currency-euro"
                                          :error="$errors->first('total_income')"/>
                        </x-input.group>

                        <x-input.group label="Additional Comments" for="comments" :error="$errors->first('comments')">
                            <x-input.textarea wire:model.lazy="comments" id="comments" rows="3"
                                              :error="$errors->first('comments')"
                                              placeholder="Any notes and/or comments about this delivery"/>
                        </x-input.group>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="button" wire:click="delete"
                            onclick="confirm('Are you sure you want to delete this job? You can not undo this action.') || event.stopImmediatePropagation()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                        Delete
                    </button>

                    <a href="{{ url()->previous() }}"
                       class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </a>

                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                        Verify
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
