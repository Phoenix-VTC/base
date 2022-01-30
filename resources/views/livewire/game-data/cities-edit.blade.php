{{-- The whole world belongs to you --}}

@section('title', 'Edit City')

@section('description')
    @if($city->approved)
        {{ $city->real_name }}
    @else
        Requested by <b>{{ $city->requester->username ?? 'Deleted User' }}</b>
    @endif
@endsection

<div>
    <x-alert/>

    @if(!$city->approved && ($city->pickupJobs->count() || $city->destinationJobs->count()))
        <x-app-ui::alert icon="iconic-information" class="mb-5">
            <x-slot name="heading">
                Heads-up!
            </x-slot>

            This city was automatically requested by the tracker.
            <br>
            Before approving, make sure that all fields marked as "unknown" are either corrected or emptied.
            <br><br>
            <b>If</b> this request needs to be denied, make sure to delete all the related jobs first, and inform the member!
            <br>
            <b>Otherwise</b>, if this request is a duplicate of an already existing city, first edit the job(s) to the other city instance, and manually approve the job.
        </x-app-ui::alert>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <x-app-ui::card>
                {{ $this->form }}

                <x-slot name="footer">
                    <x-app-ui::card.actions>
                        <x-app-ui::button tag="a" href="{{ route('game-data.cities') }}" color="secondary">
                            Cancel
                        </x-app-ui::button>

                        <x-app-ui::button type="button" wire:click="delete" color="danger"
                                          onclick="return confirm('Are you sure you want to {{ $city->approved ? 'delete' : 'deny' }} this cargo request?') || event.stopImmediatePropagation()">
                            {{ $city->approved ? 'Delete' : 'Deny' }}
                        </x-app-ui::button>

                        <x-app-ui::button type="submit" :color="$city->approved ? 'primary' : 'success'">
                            {{ $city->approved ? 'Update' : 'Approve' }}
                        </x-app-ui::button>
                    </x-app-ui::card.actions>
                </x-slot>
            </x-app-ui::card>
        </form>
    </div>

    @if($city->pickupJobs->count())
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

                @foreach($city->pickupJobs as $job)
                    <x-app-ui::table.row>
                        <x-app-ui::table.cell>
                            {{ $job->id }}
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell>
                            @if($job->user)
                                <x-app-ui::link href="{{ route('users.profile', $job->user) }}">
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

    @if($city->destinationJobs->count())
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

                @foreach($city->destinationJobs as $job)
                    <x-app-ui::table.row>
                        <x-app-ui::table.cell>
                            {{ $job->id }}
                        </x-app-ui::table.cell>

                        <x-app-ui::table.cell>
                            @if($job->user)
                                <x-app-ui::link href="{{ route('users.profile', $job->user) }}">
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
