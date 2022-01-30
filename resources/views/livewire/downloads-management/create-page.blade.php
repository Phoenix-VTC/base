{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', 'Add New Download')

<div>
    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            <div class="mt-3">
                {{ $this->form }}
            </div>

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('downloads.management.index') }}" color="secondary">
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
