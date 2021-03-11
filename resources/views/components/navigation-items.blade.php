<div class="space-y-1">
    <a href="{{ route('dashboard') }}"
       class="@if(Request::routeIs('dashboard')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        {{-- home --}}
        <svg
            class="@if(Request::routeIs('dashboard')) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6"
            xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>

    @can('manage events')
        <a href="{{ route('events.home') }}"
           class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            {{-- calendar --}}
            <svg class="text-gray-400 group-hover:text-gray-300 mr-3 h-6 w-6"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Events
        </a>
    @endif

    <a href="{{ route('vacation-requests.index') }}"
       class="@if(Request::routeIs('vacation-requests.index')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        {{-- clock --}}
        <svg
            class="@if(Request::routeIs('vacation-requests.index')) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Vacation Requests
    </a>
</div>

@hasanyrole('super admin|executive committee|human resources|recruitment|community interactions|events|media|modding')
<div class="relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center">
        <div class="px-2 bg-gray-800 text-sm text-gray-400">
            Management
        </div>
    </div>
</div>
@endhasanyrole

<div class="space-y-1">
    @can('handle driver applications')
        <a href="{{ route('recruitment.index') }}"
           class="@if(Request::routeIs('recruitment.*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            {{-- inbox --}}
            <svg
                class="@if(Request::routeIs('recruitment.*')) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            Recruitment
        </a>
    @endcan

    @can('manage vacation requests')
        <a href="{{ route('vacation-requests.manage.index') }}"
           class="@if(Request::routeIs('vacation-requests.manage.*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            {{-- document-search --}}
            <svg
                class="@if(Request::routeIs('vacation-requests.manage.*')) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Vacation Requests
        </a>
    @endcan

    @can('manage users')
        <a href="{{ route('user-management.index') }}"
           class="@if(Request::routeIs('user-management.*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            {{-- document-search --}}
            <svg
                class="@if(Request::routeIs('user-management.*')) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"/>
            </svg>
            User Management
        </a>
    @endcan

    @can('manage events')
        <a href="{{ route('event-management.index') }}"
           class="@if(Request::routeIs('event-management.*')) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            {{-- calendar --}}
            <svg
                class="@if(Request::routeIs('event-management.*')) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Events
        </a>
    @endcan
</div>
