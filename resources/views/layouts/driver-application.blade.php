@extends('layouts.base')

@section('body')
    <div class="flex flex-col justify-center min-h-screen py-12 bg-gray-900 sm:px-6 lg:px-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                @hasSection('steps')
                    <div class="px-4 py-5 sm:px-6">
                        @yield('steps')
                    </div>
                @endif
                <div class="px-4 py-5 sm:p-6 pb-5 min-h-96">
                    @if ($errors->any())
                        <div class="rounded-md bg-red-200 p-4 mb-5">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        <strong>{{ __('validation.form_validation_fail.title') }}</strong>
                                        <br>
                                        {{ __('validation.form_validation_fail.description') }}
                                    </h3>
                                    <div class="mt-2 text-sm text-red-800">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{!! $error !!}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @yield('content')
                </div>
                @if(session()->has('steam_user'))
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex-shrink-0 group block">
                            <div class="flex items-center">
                                <a href="{{ session('steam_user.profileurl') }}" target="_blank">
                                    <img class="inline-block h-9 w-9 rounded-full"
                                         src="{{ session('steam_user.avatar') }}"
                                         alt="{{ session('steam_user.personaname') }}">
                                </a>
                                <div class="ml-3">
                                    <p class="text-sm font-bold text-gray-700 group-hover:text-gray-900">
                                        <a href="{{ session('steam_user.profileurl') }}"
                                           target="_blank">{{ session('steam_user.personaname') }}</a>
                                    </p>
                                    <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">
                                        <a href="{{ route('driver-application.auth.steam.logout') }}">{{ __('actions.logout') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
