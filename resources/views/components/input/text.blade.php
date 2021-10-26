@props([
    'error' => null,
    'leadingIcon' => null,
    'trailingIcon' => null,
])

<div class="relative">
    @if($leadingIcon)
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            @svg('heroicon-' . $leadingIcon, ['class' => 'h-5 w-5 text-gray-400'])
        </div>
    @endif

    <input {{ $attributes->merge(['class' => 'mt-1 w-full shadow-sm sm:text-sm border border-gray-300 placeholder-gray-400 rounded-md' . ($error ? ' border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red' : '') . ($leadingIcon ? ' block pl-10' : '') . ($trailingIcon ? ' block pr-10' : '')]) }} />

    @if($trailingIcon)
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            @svg('heroicon-' . $trailingIcon, ['class' => 'h-5 w-5 text-gray-400'])
        </div>
    @endif
</div>
