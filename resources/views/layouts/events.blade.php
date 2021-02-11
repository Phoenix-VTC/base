@extends('layouts.base')

@section('body')
    <div class="bg-gray-900">
        <div class="relative overflow-hidden">
            @include('components.events.navigation')

            @yield('content')

            @include('components.events.footer')
        </div>
    </div>
@endsection
