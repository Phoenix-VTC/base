<nav aria-label="Progress">
    <ol class="space-y-4 md:flex md:space-y-0 md:space-x-8">
        <li class="md:flex-1">
            <!-- Completed Step -->
            <a href="#"
               class="group pl-4 py-2 flex flex-col border-l-4 border-orange-600 hover:border-orange-800 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                <span class="text-xs text-orange-600 font-semibold uppercase group-hover:text-orange-800">{{ __('slugs.step') }} 1</span>
                <span class="text-sm font-medium">{{ __('driver-application.steps.first.title') }}</span>
            </a>
        </li>

        <li class="md:flex-1">
            <!-- Current Step -->
            <a href="#"
               class="pl-4 py-2 flex flex-col border-l-4 border-orange-600 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4"
               aria-current="step">
                <span class="text-xs text-orange-600 font-semibold uppercase">{{ __('slugs.step') }} 2</span>
                <span class="text-sm font-medium">{{ __('driver-application.steps.second.title') }}</span>
            </a>
        </li>

        <li class="md:flex-1">
            <!-- Upcoming Step -->
            <a href="#"
               class="group pl-4 py-2 flex flex-col border-l-4 border-gray-200 hover:border-gray-300 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                            <span
                                class="text-xs text-gray-500 font-semibold uppercase group-hover:text-gray-700">{{ __('slugs.step') }} 3</span>
                <span class="text-sm font-medium">{{ __('driver-application.steps.third.title') }}</span>
            </a>
        </li>
    </ol>
</nav>
