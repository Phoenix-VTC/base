{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', 'Editing ' . $user->username . '\'s Account')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('users.profile', $user) }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-user class="w-5 h-5 mr-2 -ml-1 text-gray-500"/>
            View Profile
        </a>
    </div>

    <div class="ml-3">
        <div class="relative inline-block text-left" x-data="{ open: false }">
            <div>
                <button type="button"
                        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-gray-600 border border-gray-300 rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
                        id="menu-button" aria-expanded="true" aria-haspopup="true" @click="open = !open">
                    Profile Actions
                    <x-heroicon-s-chevron-down class="w-5 h-5 ml-2 -mr-1"/>
                </button>
            </div>

            <div x-show="open" x-cloak
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 z-10 w-56 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                 role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <a href="{{ route('users.removeProfilePicture', $user) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem" tabindex="-1">
                        Remove Profile Picture
                    </a>

                    <a href="{{ route('users.removeProfileBanner', $user) }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem" tabindex="-1">
                        Remove Profile Banner
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<div>
    <x-alert/>

    <form wire:submit.prevent="submit">
        <x-app-ui::card>
            <div>
                {{ $this->form }}
            </div>

            <x-slot name="footer">
                <x-app-ui::card.actions>
                    <x-app-ui::button tag="a" href="{{ route('users.profile', $user) }}" color="secondary">
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
