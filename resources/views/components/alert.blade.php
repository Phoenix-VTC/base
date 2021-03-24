@if (session()->has('alert'))
    <div
        class="rounded-md @switch(session('alert.type')) @case('info') bg-blue-200 @break @case('success') bg-green-200 @break @case('warning') bg-yellow-200 @break @case('danger') bg-red-200 @break @default bg-gray-200 @endswitch p-4 m-4">
        <div class="flex">
            <div class="flex-shrink-0">
                @switch(session('alert.type'))
                    @case('info')
                    {{-- information-circle --}}
                    <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    @break
                    @case('success')
                    {{-- check-circle --}}
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                    @break
                    @case('warning')
                    {{-- exclamation --}}
                    <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    @break
                    @case('danger')
                    {{-- ban --}}
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    @break
                @endswitch
            </div>
            <div
                class="ml-3 @switch(session('alert.type')) @case('info') text-blue-800 @break @case('success') text-green-800 @break @case('warning') text-yellow-800 @break @case('danger') text-red-800 @break @default text-gray-800 @endswitch">
                @if(session('alert.title'))
                    <h3 class="mb-2 text-sm font-bold">
                        {{ session('alert.title') }}
                    </h3>
                @endif
                <p class="text-sm font-medium">
                    {!! session('alert.message') !!}
                </p>
            </div>
        </div>
    </div>
@endif
