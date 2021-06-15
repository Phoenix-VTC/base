@props([
    'active' => false,
])

<a {{ $attributes->merge(['class' => 'text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900 ' . ($active ? 'bg-gray-100 text-gray-900' : '')]) }}
   role="menuitem" tabindex="-1">
    {{ $slot }}
</a>
