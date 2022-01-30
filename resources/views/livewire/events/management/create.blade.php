{{-- Be like water. --}}

@section('title', 'New Event')

@section('description', 'Nothing is too crazy!')

<div>
    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            {{ $this->form }}

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('event-management.index') }}" color="secondary">
                        Cancel
                    </x-app-ui::button>

                    <x-app-ui::button type="submit">
                        Create
                    </x-app-ui::button>
                </x-app-ui::card.actions>
            </x-slot>
        </x-app-ui::card>
    </form>
</div>
