{{-- Nothing in the world is as soft and yielding as water. --}}

@section('title', 'Edit Download')

@section('description', 'Keep the file inputs empty if you don\'t want to change the files.')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('downloads.management.revisions', $download) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-search class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            Revision History
        </a>
    </div>
@endsection

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
                        Edit
                    </x-app-ui::button>
                </x-app-ui::card.actions>
            </x-slot>
        </x-app-ui::card>
    </form>
</div>
