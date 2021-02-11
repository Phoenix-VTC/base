<div class="relative bg-gray-900 overflow-hidden" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto">
        <div
            class="relative z-10 pb-8 bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg
                class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-gray-900 transform translate-x-1/2"
                fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100"/>
            </svg>

            <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                <nav class="relative flex items-center justify-between sm:h-10 lg:justify-start"
                     aria-label="Global">
                    <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                        <div class="flex items-center justify-between w-full md:w-auto">
                            <a href="https://phoenixvtc.com">
                                <x-logo class="h-12 w-auto"/>
                            </a>
                            <div class="-mr-2 flex items-center md:hidden">
                                <button @click="open = true"
                                        class="bg-gray-900 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                        type="button" id="main-menu" aria-haspopup="true">
                                    <span class="sr-only">Open main menu</span>
                                    {{-- outline/menu --}}
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block md:ml-10 md:pr-4 md:space-x-8">
                        @guest
                            <a href="https://phoenixvtc.com"
                               class="font-medium text-white hover:text-gray-200">
                                Back to our main website
                            </a>

                            <a href="{{ route('events.login') }}"
                               class="font-medium text-orange-500 hover:text-orange-600">
                                Member Access
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('dashboard') }}"
                               class="font-medium text-white hover:text-gray-200">
                                Back to PhoenixBase
                            </a>

                            <a class="font-medium text-white">
                                Logged in as
                                <span class="font-bold text-orange-500">{{ Auth::user()->username }}</span>
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>

            <div x-show="open" @click.away="open = false"
                 x-cloak x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-100 ease-in"
                 x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                <div
                    class="rounded-lg shadow-md bg-gray-900 ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="px-5 pt-4 flex items-center justify-between">
                        <div>
                            <x-logo class="h-8 w-auto"/>
                        </div>
                        <div class="-mr-2">
                            <button @click="open = false" type="button"
                                    class="bg-gray-900 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="sr-only">Close main menu</span>
                                {{-- outline/x --}}
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div role="menu" aria-orientation="vertical" aria-labelledby="main-menu">
                        <div class="px-2 pt-2 pb-3 space-y-1" role="none">
                            @guest
                                <a href="https://phoenixvtc.com"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-900 hover:bg-gray-50">
                                    Back to our main website
                                </a>

                                <a href="{{ route('events.login') }}"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-900 hover:bg-gray-50">
                                    Member Access
                                </a>
                            @endguest

                            @auth
                                <a href="{{ route('dashboard') }}"
                                   class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-900 hover:bg-gray-50">
                                    Back to PhoenixBase
                                </a>

                                <a
                                    class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-900 hover:bg-gray-50">
                                    Logged in as
                                    <span class="font-bold text-orange-500">{{ Auth::user()->username }}</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hero Text --}}
            <div
                class="mt-10 mx-auto max-w-7xl px-4 py-8 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        @yield('hero-title')
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        @yield('hero-subtitle')
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- Hero Image --}}
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
             src="@yield('hero-image')"
             alt="Phoenix">
    </div>
</div>
