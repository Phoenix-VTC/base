@section('title', 'Sign in to your account')

<div>
    <div>
        <x-logo class="h-20 w-auto"/>

        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
            Sign in to your account
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Not a member yet?
            <a href="https://phoenixvtc.com/en/apply" class="font-medium text-orange-600 hover:text-orange-500">
                Join Phoenix now!
            </a>
        </p>
    </div>

    <div class="mt-8">
        <div>
            <div>
                <p class="text-sm font-medium text-gray-700">
                    Sign in with
                </p>

                <div class="mt-1 grid grid-cols-3 gap-3">
                    <div>
                        <form action="{{ route('auth.steam.redirectToSteam') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full h-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-orange-500 hover:bg-gray-50">
                                <span class="sr-only">Sign in with Steam</span>
                                <i class="fab fa-steam fa-fw fa-lg m-auto"></i>
                            </button>
                        </form>
                    </div>

                    <div>
                        <form action="{{ route('auth.discord.redirectToDiscord') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full h-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-orange-500 hover:bg-gray-50">
                                <span class="sr-only">Sign in with Discord</span>
                                <i class="fab fa-discord fa-fw fa-lg m-auto"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @if($errors->has('socialAuth'))
                    <div class="rounded-md bg-red-50 p-4 mt-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <x-heroicon-s-x-circle class="h-5 w-5 text-red-400"/>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    {{ $errors->get('socialAuth')['title'] }}
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    {!! $errors->get('socialAuth')['message'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-6 relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Or sign in with
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <form wire:submit.prevent="authenticate" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 leading-5">
                        Email address
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="email" id="email" name="email" type="email" autocomplete="email"
                               required autofocus
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"/>
                    </div>

                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 leading-5">
                        Password
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="password" id="password" type="password" autocomplete="current-password"
                               required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"/>
                    </div>

                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model.lazy="remember" id="remember" type="checkbox"
                               class="form-checkbox w-4 h-4 text-orange-600 transition duration-150 ease-in-out"/>
                        <label for="remember" class="block ml-2 text-sm text-gray-900 leading-5">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                           class="font-medium text-orange-600 hover:text-orange-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
