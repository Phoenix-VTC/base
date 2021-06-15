{{-- Success is as dangerous as failure. --}}

@section('title', $screenshot->title)

@if($screenshot->description)
    @section('description', $screenshot->description)
@endif

@section('actions')
    <div class="relative z-0 inline-flex shadow-sm rounded-md">
        <a href="{{ route('screenshot-hub.toggleVote', $screenshot) }}"
           class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
            @if($screenshot->votes()->where('user_id', Auth::id())->exists())
                <x-heroicon-s-heart class="-ml-1 mr-2 h-5 w-5 text-red-500"/>
                Unvote
            @else
                <x-heroicon-o-heart class="-ml-1 mr-2 h-5 w-5 text-red-500"/>
                Vote
            @endif
        </a>
        <span
            class="-ml-px relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700">
            {{ $screenshot->votes()->count() }}
        </span>
    </div>
@endsection

<div>
    <x-alert/>

    <div
        class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <div class="block w-full h-full rounded-lg overflow-hidden">
                <a href="{{ $screenshot->image_url }}" target="_blank">
                    <img src="{{ $screenshot->image_url }}" alt="{{ $screenshot->title }}" class="object-cover">
                </a>
            </div>
        </div>

        <div class="lg:col-start-3 lg:col-span-1 space-y-6">
            <section aria-labelledby="information-title" class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                <h2 id="information-title" class="text-lg font-medium text-gray-900">Information</h2>
                <div class="mt-6 flow-root">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Uploaded by</dt>
                            <dd class="text-gray-900 prose prose-sm prose-red">
                                @if($screenshot->user)
                                    <a href="{{ route('users.profile', $screenshot->user) }}">
                                        {{ $screenshot->user->username }}
                                    </a>
                                @else
                                    <span class="text-indigo-600">
                                        Unknown User
                                    </span>
                                @endif
                            </dd>
                        </div>

                        @if($screenshot->location)
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">Location</dt>
                                <dd class="text-gray-900">{{ $screenshot->location }}</dd>
                            </div>
                        @endif

                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">{{ Str::plural('Vote', $screenshot->votes->count()) }}</dt>
                            <dd class="text-gray-900">{{ $screenshot->votes->count() }}</dd>
                        </div>

                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Submitted At</dt>
                            <dd class="text-gray-900">{{ $screenshot->created_at->toDayDateTimeString() }}</dd>
                        </div>

                    </dl>
                </div>
                @if(Auth::id() === $screenshot->user_id || Auth::user()->can('manage users'))
                    <div class="mt-6 flex flex-col justify-stretch space-y-2">
                        <button type="button" wire:click="delete" wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-wait"
                                onclick="confirm('Are you sure you want to delete this screenshot? This action is irreversible.') || event.stopImmediatePropagation()"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete screenshot
                        </button>
                        <p class="text-center text-xs text-gray-500">
                            This action is irreversible.
                        </p>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
