{{-- The whole world belongs to you --}}

@section('title', 'Edit Cargo')

@section('description')
    @if($cargo->approved)
        {{ $cargo->name }}
    @else
        Requested by <b>{{ $cargo->requester->username ?? 'Deleted User' }}</b>
    @endif
@endsection

<div>
    <x-alert/>

    @if(!$cargo->approved && $cargo->jobs->count())
        <x-app-ui::alert icon="iconic-information" class="mb-5">
            <x-slot name="heading">
                Heads-up!
            </x-slot>

            This cargo was automatically requested by the tracker.
            <br>
            Before approving, make sure that all fields marked as "unknown" are either corrected or emptied.
            <br><br>
            <b>If</b> this request needs to be denied, make sure to delete all the related jobs first, and inform the member!
            <br>
            <b>Otherwise</b>, if this request is a duplicate of an already existing cargo, first edit the job(s) to the other cargo instance, and manually approve the job.
        </x-app-ui::alert>
    @endif

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <x-app-ui::card>
                {{ $this->form }}

                <x-slot name="footer">
                    <x-app-ui::card.actions>
                        <x-app-ui::button tag="a" href="{{ route('game-data.cargos') }}" color="secondary">
                            Cancel
                        </x-app-ui::button>

                        <x-app-ui::button type="submit">
                            Update
                        </x-app-ui::button>
                    </x-app-ui::card.actions>
                </x-slot>
            </x-app-ui::card>
        </form>
    </div>

    @if($cargo->jobs->count())
        <x-app-ui::card class="mt-5">
            <x-slot name="header">
                <x-app-ui::card.heading>
                    Related Jobs
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
                            Job Actions
                        </x-app-ui::sr-only>
                    </x-app-ui::table.column>
                </x-slot>

                @foreach($cargo->jobs as $job)
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
                            <div class="space-x-5">
                                <x-app-ui::table.cell.action tag="a" href="{{ route('jobs.show', $job->id) }}">
                                    View Job
                                </x-app-ui::table.cell.action>

                                <x-app-ui::table.cell.action tag="a" href="{{ route('jobs.edit', $job->id) }}">
                                    Edit Job
                                </x-app-ui::table.cell.action>
                            </div>
                        </x-app-ui::table.cell>
                    </x-app-ui::table.row>
                @endforeach
            </x-app-ui::table>
        </x-app-ui::card>
    @endif
</div>
