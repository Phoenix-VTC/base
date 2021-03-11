<div>
    <footer class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
        <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
            <div class="px-5 py-2">
                <a href="{{ route('events.home') }}" class="text-base text-gray-500 hover:text-gray-400">
                    Home
                </a>
            </div>

            <div class="px-5 py-2">
                <a href="https://phoenixvtc.com" class="text-base text-gray-500 hover:text-gray-400">
                    Main Website
                </a>
            </div>

            <div class="px-5 py-2">
                <a href="{{ route('dashboard') }}" class="text-base text-gray-500 hover:text-gray-400">
                    PhoenixBase
                </a>
            </div>

            <div class="px-5 py-2">
                <a href="https://phoenixvtc.com/en/apply" class="text-base text-gray-500 hover:text-gray-400">
                    Apply
                </a>
            </div>
        </nav>
        <div class="mt-8 flex justify-center space-x-6">
            <a href="https://phoenixvtc.com">
                <img class="h-12 w-auto"
                     src="{{ asset('img/logo.svg') }}" alt="Phoenix">
            </a>
        </div>
        <p class="mt-8 text-center text-base text-gray-400">
            &copy; 2020 - {{ date('Y') }} PhoenixVTC. All rights reserved.
        </p>
    </footer>
</div>
