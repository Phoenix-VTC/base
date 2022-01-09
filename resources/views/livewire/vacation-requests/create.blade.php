@section('title', 'New Vacation Request')

@section('description')
    Going away for a while, or do you want to leave Phoenix?
    <br>
    You can submit a vacation request here.
@endsection

<div>
    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            <div class="mt-3">
                {{ $this->form }}
            </div>

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('vacation-requests.index') }}" color="secondary">
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
