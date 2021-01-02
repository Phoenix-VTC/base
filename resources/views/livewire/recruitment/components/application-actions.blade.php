<section class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
    <h2 id="tmp-information-title" class="text-lg font-medium text-gray-900">Application Information</h2>
    <div class="mt-6 flow-root">
        <ul class="-mb-8">
            {{-- Claimed By --}}
            <li>
                <div class="relative pb-8">
                    <div class="relative flex space-x-3">
                        <div>
                            <span
                                class="h-8 w-8 rounded-full @if($application->claimed_by) bg-blue-500 @else bg-gray-400 @endif flex items-center justify-center ring-8 ring-white">
                                {{-- user --}}
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    @if($application->claimed_by)
                                        Claimed by <strong>{{ $application->owner->username }}</strong>
                                    @else
                                        Unclaimed
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            {{-- Status --}}
            <li>
                <div class="relative pb-8">
                    <div class="relative flex space-x-3">
                        <div>
                            <span
                                class="h-8 w-8 rounded-full bg-indigo-400 flex items-center justify-center ring-8 ring-white">
                                {{-- collection --}}
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Status:
                                    <strong>
                                        @if(!$application->claimed_by)
                                            Unclaimed
                                        @else
                                            {{ ucwords(str_replace("_", " ", $application->status)) }}
                                        @endif
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    @if($application->claimed_by)
        <div class="mt-6 flex flex-col justify-stretch space-y-3">
            <button type="button"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                Accept
            </button>

            <button type="button"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
                Deny
            </button>
        </div>
    @endif
</section>
