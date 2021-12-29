{{-- The whole world belongs to you --}}

@section('title', 'Manage Cargos')

<div>
    <livewire:game-data.cargos.datatable/>

    <x-page-divider title="Add New Cargo"/>

    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <x-app-ui::card>
                <div class="mt-3">
                    {{ $this->form }}
                </div>

                <x-slot name="footer">
                    <x-app-ui::card.actions>
                        <x-app-ui::button type="submit">
                            Add
                        </x-app-ui::button>
                    </x-app-ui::card.actions>
                </x-slot>
            </x-app-ui::card>
        </form>
    </div>
</div>
