@extends('layouts.base')

@push('scripts')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GTHGG9KZ2L"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-GTHGG9KZ2L');
    </script>
@endpush

@section('body')
    <div class="h-screen flex overflow-hidden bg-gray-100" x-data="{ sidebarOpen: false }">
        @include('includes.sidebar')
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            @impersonating($guard = null)
                <div class="bg-purple-50 border-l-4 border-purple-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-identification class="h-5 w-5 text-purple-400"/>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-purple-700">
                                You are currently impersonating
                                <a class="font-semibold" href="{{ route('users.profile', Auth::id()) }}">
                                    {{ Auth::user()->username }}
                                </a>
                            </p>
                            <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                <a href="{{ route('impersonate.leave') }}" class="whitespace-nowrap font-medium text-purple-700 hover:text-purple-600">
                                    Stop Impersonating
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            @endImpersonating

            @include('includes.navigation')

            <main class="flex-1 relative overflow-y-auto focus:outline-none" tabindex="0">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mb-8">
                        <div class="lg:flex lg:items-center lg:justify-between">
                            <div class="flex-1 min-w-0">
                                <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                                    @yield('title')
                                </h2>

                                @hasSection('description')
                                    <p class="my-2 max-w-4xl text-sm text-gray-500">
                                        @yield('description')
                                    </p>
                                @endif

                                @hasSection('meta')
                                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                        @yield('meta')
                                    </div>
                                @endif
                            </div>
                            @hasSection('actions')
                                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                                    @yield('actions')
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
