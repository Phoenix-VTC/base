<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gray-50 overflow-hidden shadow rounded-lg divide-y divide-gray-200">
        <div class="px-4 py-5 sm:px-6">
            @include('livewire.driver-application.components.steps', ['current' => 2])
        </div>
        <div class="px-4 py-5 sm:p-6 pb-5 h-96 text-center">
            <h3 class="text-2xl leading-6 font-bold text-gray-900 pb-5">
                Log in with Steam
            </h3>
            <img class="object-contain h-48 w-full pb-5" src="{{ asset('img/illustrations/hire.svg') }}"
                 alt="Illustration"/>
            <a class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
               href="{{ route('driver-application.auth.steam') }}">
                <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                          clip-rule="evenodd"/>
                </svg>
                Authenticate
            </a>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if(session()->has('steam_user'))
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
                            <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700" href="#">
                                <a href="{{ route('driver-application.auth.steam.logout') }}">Log out</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
