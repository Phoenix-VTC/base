@extends('layouts.base')

@section('body')
    <div class="h-screen flex overflow-hidden bg-gray-100" x-data="{ sidebarOpen: false }">
        @include('components.sidebar')
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            @include('components.navigation')

            <main class="flex-1 relative overflow-y-auto focus:outline-none" tabindex="0">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        @hasSection('custom-title')
                            @yield('custom-title')
                        @else
                            <h1 class="text-2xl font-semibold text-gray-900 border-b border-gray-200">@yield('title')</h1>
                        @endif
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
