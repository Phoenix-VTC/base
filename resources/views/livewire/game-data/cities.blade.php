{{-- The whole world belongs to you --}}

@section('title', 'Manage Cities')

<div>
    <livewire:game-data.cities.datatable/>

    <x-page-divider title="Add New City"/>

    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <x-app-ui::card>
                {{ $this->form }}

                <x-slot name="footer">
                    <x-app-ui::card.actions>
                        <x-app-ui::button type="submit">
                            Update
                        </x-app-ui::button>
                    </x-app-ui::card.actions>
                </x-slot>
            </x-app-ui::card>
        </form>
    </div>
</div>
