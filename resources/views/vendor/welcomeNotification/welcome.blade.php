@extends('layouts.auth')
@section('title', 'Choose your password')

@push('scripts')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
    <div>
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-logo class="w-auto h-40 mx-auto"/>

            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
                Choose your password
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
                This will be used for your {{ config('app.name') }} account
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
                <form method="post">
                    @csrf

                    <input type="hidden" name="email" value="{{ $user->email }}"/>

                    <div class="mt-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 leading-5">
                            Password
                        </label>

                        <div class="mt-1 rounded-md shadow-sm">
                            <input name="password" id="password" type="password" required autocomplete="new-password"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"/>
                        </div>

                        @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 leading-5">
                            Confirm Password
                        </label>

                        <div class="mt-1 rounded-md shadow-sm">
                            <input name="password_confirmation" id="password_confirmation" type="password"
                                   required autocomplete="new-password"
                                   class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 appearance-none rounded-md focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                        </div>
                    </div>

                    <div class="mt-6">
                        {!! NoCaptcha::display() !!}

                        @error('g-recaptcha-response')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                        <button type="submit"
                                class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:ring-orange active:bg-orange-700 transition duration-150 ease-in-out">
                            Finish registration
                        </button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
