@props([
    'title',
    'icon',
    'route',
    'activeRoute' => null,
])

<a class="@if(Request::routeIs($activeRoute ?? $route)) bg-red-50 border-red-500 text-red-700 hover:bg-red-50 hover:text-red-700 @else border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 @endif group border-l-4 px-3 py-2 flex items-center text-sm font-medium"
   href="{{ route($route) }}">
    <span
        class="@if(Request::routeIs($activeRoute ?? $route)) text-red-500 group-hover:text-red-500 @else text-gray-400 group-hover:text-gray-500 @endif flex-shrink-0 -ml-1 mr-3 h-6 w-6">
        @svg('heroicon-' . $icon)
    </span>
    <span class="truncate">
        {{ $title }}
    </span>
</a>
