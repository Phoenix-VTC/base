@extends('layouts.base')

@section('body')
    <div class="bg-gray-900">
        <div class="relative overflow-hidden">
            @include('components.events.navigation')

            <main>
                @yield('content')
            </main>

            @include('components.events.footer')
        </div>
    </div>
@endsection
