<div class="flex space-x-1 justify-around">
    <a href="{{ route('users.profile', [$id]) }}" class="p-1 text-teal-600 hover:bg-teal-600 hover:text-white rounded">
        <x-heroicon-s-eye class="w-5 h-5"/>
    </a>

    <a href="{{ route('users.edit', [$id]) }}" class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
        <x-heroicon-s-pencil class="w-5 h-5"/>
    </a>
</div>
