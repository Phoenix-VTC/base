{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', 'Submit a new screenshot')

<div>
    <x-alert/>

    <x-app-ui::alert icon="iconic-information" class="mb-4">
        <x-slot name="heading">
            Please read this before submitting a screenshot!
        </x-slot>

        <ul class="list-disc">
            <li>You can submit a maximum of one screenshot every 24 hours.</li>
            <li>Submissions needs to be yours. You cannot submit someone else's creation.</li>
            <li>The screenshot must be taken in either Euro Truck Simulator 2 or American Truck Simulator.</li>
        </ul>
    </x-app-ui::alert>

    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            <div class="mt-3">
                {{ $this->form }}
            </div>

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('screenshot-hub.index') }}" color="secondary">
                        Cancel
                    </x-app-ui::button>

                    <x-app-ui::button type="submit">
                        Submit
                    </x-app-ui::button>
                </x-app-ui::card.actions>
            </x-slot>
        </x-app-ui::card>
    </form>
</div>
