{{-- The whole world belongs to you --}}

@section('title', 'Edit Company')

@section('description')
    @if($company->approved)
        {{ $company->name }}
    @else
        Requested by <b>{{ $company->requester->username ?? 'Deleted User' }}</b>
    @endif
@endsection

<div>
    <x-alert/>

    @if(!$company->approved && ($company->pickupJobs->count() || $company->destinationJobs->count()))
        <x-app-ui::alert icon="iconic-information" class="mb-5">
            <x-slot name="heading">
                Heads-up!
            </x-slot>

            This company was automatically requested by the tracker.
            <br>
            Before approving, make sure that all fields marked as "unknown" are either corrected or emptied.
            <br><br>
            <b>If</b> this request needs to be denied, make sure to delete all the related jobs first, and inform the member!
            <br>
            <b>Otherwise</b>, if this request is a duplicate of an already existing company, first edit the job(s) to the other company instance, and manually approve the job.
        </x-app-ui::alert>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <div class="shadow overflow-hidden rounded-xl">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        @csrf

                        <x-input.group label="Name" for="name" :error="$errors->first('name')" col-span="3">
                            <x-input.text wire:model.lazy="name" type="text" id="name"
                                          :error="$errors->first('name')" autocomplete="off"/>
                        </x-input.group>

                        <br>

                        <x-input.group label="Category" for="category" :error="$errors->first('category')" col-span="3">
                            <x-input.text wire:model.lazy="category" type="text" id="category"
                                          :error="$errors->first('category')"/>
                        </x-input.group>

                        <x-input.group label="Specialization" for="specialization" :error="$errors->first('specialization')" col-span="3">
                            <x-input.text wire:model.lazy="specialization" type="text" id="specialization"
                                          :error="$errors->first('specialization')"/>
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
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    @if($company->approved)
                        <button type="button" wire:click="delete"
                                onclick="confirm('Are you sure you want to delete this company?') || event.stopImmediatePropagation()"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    @else
                        <button type="button" wire:click="delete"
                                onclick="return confirm('Are you sure you want to deny this company request?') || event.stopImmediatePropagation()"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                            Deny
                        </button>
                    @endif

                    <a href="{{ route('game-data.companies') }}"
                       class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </a>

                    @if($company->approved)
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                            Update
                        </button>
                    @else
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to approve this company request?')"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 mt-3 sm:mt-0 sm:w-auto sm:text-sm">
                            Approve
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if($company->pickupJobs->count())
        <x-app-ui::card class="mt-5">
            <x-slot name="header">
                <x-app-ui::card.heading>
                    Related Pickup Jobs
                </x-app-ui::card.heading>
            </x-slot>

            <x-app-ui::table>
                <x-slot name="columns">
                    <x-app-ui::table.column>
                        Job ID
                    </x-app-ui::table.column>

                    <x-app-ui::table.column>
                        User
                    </x-app-ui::table.column>

                    <x-app-ui::table.column>
                        Created At
                    </x-app-ui::table.column>

                    <x-app-ui::table.column>
                        <x-app-ui::sr-only>
                            View Job
                        </x-app-ui::sr-only>
                    </x-app-ui::table.column>
                </x-slot>

                @foreach($company->pickupJobs as $job)
                    <x-app-ui::table.row>
                        <x-app-ui::table.cell>
                            {{ $job->id }}
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell>
                            @if($job->user)
                                <x-app-ui::link href="{{ route('users.profile', $job->user->id) }}">
                                    {{ $job->user->username }}
                                </x-app-ui::link>
                            @else
                                Deleted User
                            @endif
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell>
                            {{ $job->created_at }}
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell align="right">
                            <x-app-ui::table.cell.action tag="a" href="{{ route('jobs.show', $job->id) }}">
                                View Job
                            </x-app-ui::table.cell.action>
                        </x-app-ui::table.cell>
                    </x-app-ui::table.row>
                @endforeach
            </x-app-ui::table>
        </x-app-ui::card>
    @endif

    @if($company->destinationJobs->count())
        <x-app-ui::card class="mt-5">
            <x-slot name="header">
                <x-app-ui::card.heading>
                    Related Destination Jobs
                </x-app-ui::card.heading>
            </x-slot>

            <x-app-ui::table>
                <x-slot name="columns">
                    <x-app-ui::table.column>
                        Job ID
                    </x-app-ui::table.column>

                    <x-app-ui::table.column>
                        User
                    </x-app-ui::table.column>

                    <x-app-ui::table.column>
                        Created At
                    </x-app-ui::table.column>

                    <x-app-ui::table.column>
                        <x-app-ui::sr-only>
                            View Job
                        </x-app-ui::sr-only>
                    </x-app-ui::table.column>
                </x-slot>

                @foreach($company->destinationJobs as $job)
                    <x-app-ui::table.row>
                        <x-app-ui::table.cell>
                            {{ $job->id }}
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell>
                            @if($job->user)
                                <x-app-ui::link href="{{ route('users.profile', $job->user->id) }}">
                                    {{ $job->user->username }}
                                </x-app-ui::link>
                            @else
                                Deleted User
                            @endif
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell>
                            {{ $job->created_at }}
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell align="right">
                            <x-app-ui::table.cell.action tag="a" href="{{ route('jobs.show', $job->id) }}">
                                View Job
                            </x-app-ui::table.cell.action>
                        </x-app-ui::table.cell>
                    </x-app-ui::table.row>
                @endforeach
            </x-app-ui::table>
        </x-app-ui::card>
    @endif
</div>
