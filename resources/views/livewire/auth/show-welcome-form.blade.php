@section('title', 'Choose your password')

<div>
    <div>
        <x-logo class="h-20 w-auto"/>

        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
            Choose your password
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            This will be used for your {{ config('app.name') }} account.
        </p>
    </div>

    <div class="mt-8">
        <form wire:submit.prevent="submit" class="space-y-6">
            @csrf

            <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700 leading-5">
                    Password
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="password" id="password" type="password" autocomplete="current-password"
                           required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"/>
                </div>

                @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 leading-5">
                    Confirm Password
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="passwordConfirmation" id="password_confirmation" type="password" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 appearance-none rounded-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Finish registration
                </button>
            </div>
        </form>
    </div>
</div>
