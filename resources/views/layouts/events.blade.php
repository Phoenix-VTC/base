@extends('layouts.base')

@push('scripts')
    {{-- TEMP-WINTER --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Snowstorm/20131208/snowstorm-min.js"
            integrity="sha512-rMkLONrw50boYG/6Ku0E8VstfWMRn5D0dX3QZS26Mg0rspYq4EHxYOULuPbv9Be2HBbrrmN8dpPgYUeJ4bINCA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

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
