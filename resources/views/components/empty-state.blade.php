<div class="overflow-hidden shadow bg-white text-center">
    <div class="px-4 py-5 sm:px-6 mt-4 flex">
        <img class="mx-auto" width="45%"
             src="{{ $image }}"
             alt="{{ $alt }}"/>
    </div>
    <div class="px-4 py-5 sm:p-6">
        <h1 class="text-4xl font-semibold text-gray-900">
            {{ $slot }}
        </h1>
    </div>
</div>
