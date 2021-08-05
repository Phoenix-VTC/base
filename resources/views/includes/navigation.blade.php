<div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
    <button
        class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
        @click="sidebarOpen = true">
        <span class="sr-only">Open sidebar</span>
        {{-- menu-alt-2 --}}
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
        </svg>
    </button>
    <div class="flex-1 px-4 flex justify-between">
        <div class="flex-1 flex"></div>
        <div class="ml-4 flex items-center md:ml-6">
            <x-dropdown icon="o-bell" title="View notifications" width="w-80" :notification-dot-color="Auth::user()->unreadNotifications->count() ? 'bg-red-400' : ''">
                <ul class="divide-y divide-gray-200">
                    @forelse(Auth::user()->unreadNotifications as $notification)
                        <li class="relative bg-white py-5 px-4 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                            <form class="flex justify-between" method="POST"
                                  action="{{ route('notifications.markAsRead', $notification->id) }}">
                                @csrf
                                <div class="min-w-0 flex-1">
                                    <button type="submit"
                                            class="text-sm font-semibold text-gray-800 hover:underline focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $notification->data['title'] ?? '' }}
                                    </button>
                                </div>
                                <time datetime="{{ $notification->created_at }}"
                                      class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                                    {{ $notification->created_at->diffForHumans(['short' => true]) }}
                                </time>
                            </form>
                            <div class="mt-1">
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                    {!! Str::words($notification->data['content'] ?? '', 10) !!}
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="relative bg-white py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                            <p class="line-clamp-2 text-sm text-gray-600">
                                You don't have any unread notifications!
                            </p>
                        </li>
                    @endforelse
                </ul>
                <div class="mt-6 mb-3 px-4">
                    <a href="{{ route('notifications.index') }}"
                       class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 px-2">
                        View all notifications
                    </a>
                </div>
            </x-dropdown>

            {{-- Profile Dropdown --}}
            <div class="ml-3 relative" x-data="{ profileOpen: false }">
                <div>
                    <button
                        class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        id="user-menu" aria-haspopup="true" @click="profileOpen = true">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full"
                             src="{{ Auth::user()->profile_picture }}"
                             alt="{{ Auth::user()->username }}" height="32" width="32">
                    </button>
                </div>
                <div
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu" x-show="profileOpen"
                    @click.away="profileOpen = false" x-cloak
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95">
                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                       role="menuitem">
                        Profile
                    </a>

                    <a href="{{ route('users.achievements', Auth::id()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                       role="menuitem">
                        Achievements
                    </a>

                    <a href="{{ route('my-wallet') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                       role="menuitem">
                        Wallet
                    </a>

                    <a href="{{ route('settings.preferences') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        Settings
                    </a>

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left"
                                role="menuitem">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
