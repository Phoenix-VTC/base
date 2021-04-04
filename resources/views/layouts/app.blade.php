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
        @include('components.sidebar')
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            @include('components.navigation')

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
