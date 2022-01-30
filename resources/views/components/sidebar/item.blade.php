@props([
    'title',
    'icon',
    'route',
    'activeRoute' => null,
    'unreadCount' => 0,
])

<a href="{{ route($route) }}"
   class="@if(Request::routeIs($activeRoute ?? $route)) bg-gray-900 text-white @else text-gray-300 hover:bg-gray-700 hover:text-white @endif group flex items-center px-2 py-2 text-sm font-medium rounded-md">

    <span
        class="@if(Request::routeIs($activeRoute ?? $route)) text-gray-300 @else text-gray-400 group-hover:text-gray-300 @endif mr-3 h-6 w-6">
        @svg('heroicon-' . $icon)
    </span>

    <span class="flex-1">
        {{ $title }}
    </span>

    @if($unreadCount > 0)
        <span class="@if(Request::routeIs($activeRoute ?? $route)) bg-gray-800 @else bg-gray-900 group-hover:bg-gray-800 @endif ml-3 inline-block py-0.5 px-3 text-xs font-medium rounded-full">
          {{ $unreadCount }}
        </span>
    @endif
</a>
