<form class="text-center" action="{{ route('driver-application.auth.steam') }}" method="POST">
    @csrf
    <h3 class="text-2xl leading-6 font-bold text-gray-900 pb-5">
        {{ __('slugs.login_steam') }}
    </h3>
    <img class="object-contain h-48 w-full pb-5" src="{{ asset('img/illustrations/hire.svg') }}"
         alt="Illustration"/>
    <button
        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
        type="submit">
        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
             fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                  d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                  clip-rule="evenodd"/>
        </svg>
        {{ __('actions.authenticate') }}
    </button>
</form>
