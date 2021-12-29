{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

@section('title', 'Submit New ' . App\Models\Game::GAMES[$game_id][0] . ' Job')

@section('description')
    Missing a city, company or cargo in our database? Request it <a class="font-semibold text-gray-900"
                                                                    href="{{ route('jobs.request-game-data') }}">here</a>!
@endsection

<div>
    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            {{ $this->form }}

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('jobs.personal-overview') }}" color="secondary">
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
