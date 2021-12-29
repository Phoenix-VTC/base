{{-- The Master doesn't talk, he acts. --}}

@section('title', "Verify Job #{$job->id}")

<div>
    <x-alert/>

    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            {{ $this->form }}

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('jobs.show', $job->id) }}" color="secondary">
                        Cancel
                    </x-app-ui::button>

                    <x-app-ui::button type="submit">
                        Verify
                    </x-app-ui::button>
                </x-app-ui::card.actions>
            </x-slot>
        </x-app-ui::card>
    </form>
</div>
