{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day --}}

@section('title', 'Downloads Management')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('downloads.management.create') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add New Download
        </a>
    </div>
@endsection

<div>
    <x-alert/>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    @empty(!$downloads->count())
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    File
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Download Count
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Updated At
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($downloads as $download)
                                <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $download->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 capitalize">
                                        {{ $download->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $download->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ $download->image_url }}" target="_blank"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="downloadFile({{ $download }})"
                                                class="font-medium text-indigo-600 hover:text-indigo-900">
                                            Download
                                        </button>
                                        <br>
                                        <span class="text-xs text-gray-500">
                                            ({{ $download->file_size }} MB)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $download->download_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $download->updated_at->toDayDateTimeString() }}
                                        <br>
                                        <span class="text-xs">
                                            Modified by <b>{{ $download->updatedBy->username ?? 'Unknown User' }}</b>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('downloads.management.edit', $download) }}"
                                           class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <button type="button"
                                                onclick="confirm('Are you sure you want to delete this download?') || event.stopImmediatePropagation()"
                                                wire:click="delete({{ $download }})"
                                                class="ml-2 font-medium text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <x-empty-state :image="asset('img/illustrations/add_files.svg')"
                                       alt="Add files illustration">
                            Hmm, it looks like there are no downloads yet.
                            <br>
                            Why don't you add some?
                        </x-empty-state>
                    @endempty
                </div>
            </div>
        </div>
    </div>
</div>
