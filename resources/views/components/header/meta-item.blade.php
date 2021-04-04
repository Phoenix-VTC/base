@props([
    'icon' => null,
])

<div class="mt-2 flex items-center text-sm text-gray-500">
    @if($icon)
        @svg('heroicon-' . $icon, ['class' => 'flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400'])
    @endif

    {!! $slot !!}
</div>
