{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

@section('title', 'Editing Job #' . $job->id)

<div>
    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            {{ $this->form }}

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('jobs.show', $job->id) }}" color="secondary">
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
