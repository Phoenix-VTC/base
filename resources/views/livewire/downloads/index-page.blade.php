{{-- The whole world belongs to you --}}

@section('title', 'Downloads')

<div>
    <x-alert/>

    @if($downloads->count())
        <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">

            @foreach($downloads as $download)
                <li class="relative cursor-pointer" wire:click="downloadFile({{ $download }})">
                    <div
                        class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                        <img
                            src="{{ $download->image_url }}"
                            alt="{{ $download->name }} thumbnail"
                            class="object-cover pointer-events-none group-hover:opacity-75">
                        <button type="button" class="absolute inset-0 focus:outline-none">
                            <span class="sr-only">Download {{ $download->name }}</span>
                        </button>
                    </div>
                    <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">{{ $download->name }}</p>
                    <p class="block text-xs font-medium text-gray-900 truncate pointer-events-none">
                        {{ $download->download_count }} downloads
                    </p>
                    @isset($download->description)
                        <p class="block text-sm font-medium text-gray-500 pointer-events-none">{{ $download->description }}</p>
                    @endisset
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state :image="asset('img/illustrations/empty.svg')"
                       alt="Empty illustration">
            Hmm, it looks like there are no downloads available yet.
        </x-empty-state>
    @endif
</div>
