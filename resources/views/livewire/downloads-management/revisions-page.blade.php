{{-- Care about people's approval and you will be their prisoner. --}}

@section('title', ucwords($download->name) . ' Revision History')

<div>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            User ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap">
                            Field Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap">
                            Old Value
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase whitespace-nowrap">
                            New Value
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($download->revisionHistoryWithUser as $revision)
                        <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif">
                            <td class="px-6 py-4 text-sm prose-sm prose text-gray-900 whitespace-nowrap">
                                @if($revision->user)
                                    <a href="{{ route('users.profile', $revision->user) }}">
                                        {{ $revision->user->username ?? 'Deleted User' }}
                                    </a>
                                @else
                                    <span class="font-semibold">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $revision->fieldName() ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $revision->oldValue() ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $revision->newValue() ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $revision->created_at }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                There is no revision history available yet for this download.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
