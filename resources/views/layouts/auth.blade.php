@extends('layouts.base')

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
            <img class="absolute inset-0 h-full w-full object-cover"
                 src="https://phoenix-base.s3.nl-ams.scw.cloud/images/snow_background.png"
                 alt="A Phoenix truck and trailer driving on a snowy road">
        </div>
    </div>
@endsection
