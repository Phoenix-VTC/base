{{-- Success is as dangerous as failure. --}}

@section('title', 'Request Game Data')

@section('description')
    Missing something in our database? Request it here!
    <br>
    Please make sure that the city, company or cargo doesn't exist yet, and that all the information is correct.
@endsection

<div>
    <x-alert/>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="submit">
            <x-app-ui::card>
                {{ $this->form }}

                <x-slot name="footer">
                    <x-app-ui::card.actions>
                        <x-app-ui::button tag="a" href="{{ url()->previous() }}" color="secondary">
                            Go back
                        </x-app-ui::button>

                        <x-app-ui::button type="submit">
                            Submit Request
                        </x-app-ui::button>
                    </x-app-ui::card.actions>
                </x-slot>
            </x-app-ui::card>
        </form>
    </div>
</div>
