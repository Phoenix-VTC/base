@extends('layouts.base')

{{-- TEMP-WINTER --}}
@push('scripts')
    @once
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Snowstorm/20131208/snowstorm-min.js"
                integrity="sha512-rMkLONrw50boYG/6Ku0E8VstfWMRn5D0dX3QZS26Mg0rspYq4EHxYOULuPbv9Be2HBbrrmN8dpPgYUeJ4bINCA=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endonce
    <script>
        snowStorm.targetElement = 'cover-image'; // Render it in the cover-image div
        snowStorm.followMouse = false; // Snowflakes won't follow the mouse
        snowStorm.animationInterval = 100; // Set the interval for the snow to fall (lower value = more snow)
    </script>
@endpush

@section('body')
    <div class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                @yield('content')

                @isset($slot)
                    {{ $slot }}
                @endisset

                <x-alert/>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1" id="cover-image">
            {{-- TEMP-WINTER --}}
            <img class="absolute inset-0 h-full w-full object-cover"
                 src="https://phoenix-base.s3.nl-ams.scw.cloud/images/snow_background.png"
                 alt="A Phoenix truck and trailer driving on a snowy road">
        </div>
    </div>
@endsection
