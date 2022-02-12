{{-- The whole world belongs to you --}}

@section('title', 'Downloads')

<div>
    <x-alert/>

    @if($downloads->count())
        <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8" wire:loading.remove wire:target="downloadFile">
            @foreach($downloads as $download)
                <li class="relative">
                    <div
                        class="block w-full overflow-hidden bg-gray-100 rounded-lg aspect-w-10 aspect-h-7 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500">
                        <img
                            src="{{ $download->image_url }}"
                            alt="{{ $download->name }} thumbnail"
                            class="object-cover pointer-events-none">
                    </div>
                    <p class="block mt-2 text-sm font-medium text-gray-900 truncate pointer-events-none">{{ $download->name }}</p>
                    <p class="block text-xs font-medium text-gray-900 truncate pointer-events-none">
                        {{ $download->download_count }} downloads
                    </p>
                    @isset($download->description)
                        <p class="block text-sm font-medium text-gray-500 pointer-events-none">{{ $download->description }}</p>
                    @endisset
                    <button wire:click="downloadFile({{ $download }})" class="w-full px-4 py-2 mt-2 text-sm font-medium text-center text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Download</button>
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state :image="asset('img/illustrations/empty.svg')"
                       alt="Empty illustration">
            Hmm, it looks like there are no downloads available yet.
        </x-empty-state>
    @endif

    <div wire:loading wire:target="downloadFile">
        <x-empty-state :image="asset('img/illustrations/folder_files.svg')"
                       alt="Folder with files illustration">
            We are preparing your download, hold on for just a second!
        </x-empty-state>
    </div>
</div>
