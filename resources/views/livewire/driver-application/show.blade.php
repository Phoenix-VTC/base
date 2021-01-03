@section('steps')
    <nav aria-label="Progress">
        <ol class="space-y-4 md:flex md:space-y-0 md:space-x-8">
            <li class="md:flex-1">
                <a href="#"
                   class="group pl-4 py-2 flex flex-col border-l-4 border-orange-600 hover:border-orange-800 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                    <span class="text-xs text-orange-600 font-semibold uppercase group-hover:text-orange-800">{{ __('slugs.step') }} 1</span>
                    <span class="text-sm font-medium">Application Submitted</span>
                </a>
            </li>

            <li class="md:flex-1">
                <a href="#"
                   class="group pl-4 py-2 flex flex-col border-l-4 border-orange-600 hover:border-orange-800 md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4"
                   aria-current="step">
                    <span class="text-xs text-orange-600 font-semibold uppercase group-hover:text-orange-800">{{ __('slugs.step') }} 2</span>
                    <span class="text-sm font-medium">Application In Progress</span>
                </a>
            </li>

            <li class="md:flex-1">
                <a href="#"
                   class="group pl-4 py-2 flex flex-col border-l-4 @if(!$application->isCompleted) border-gray-200 hover:border-gray-300 @else border-orange-600 hover:border-orange-800 @endif md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4">
                    <span
                        class="text-xs @if(!$application->isCompleted) text-gray-500 group-hover:text-gray-700 @else text-orange-600 group-hover:text-orange-800 @endif font-semibold uppercase">{{ __('slugs.step') }} 3</span>
                    <span class="text-sm font-medium">Application Complete</span>
                </a>
            </li>
        </ol>
    </nav>
@endsection

<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>
