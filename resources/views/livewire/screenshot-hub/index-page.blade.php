{{-- Be like water. --}}

@section('title', 'Screenshot Hub')

@section('description', 'Want to show off that sweet screenshot you took? This is the place to be!')

@section('actions')
    <div class="ml-3">
        <x-dropdown :title="'One ' . ucfirst($range)">
            <x-dropdown-item
                href="{{ route('screenshot-hub.index', ['desc' => $desc, 'orderBy' => $orderBy, 'range' => 'week']) }}"
                :active="($range === 'week')">
                One Week
            </x-dropdown-item>
            <x-dropdown-item
                href="{{ route('screenshot-hub.index', ['desc' => $desc, 'orderBy' => $orderBy, 'range' => 'month']) }}"
                :active="($range === 'month')">
                One Month
            </x-dropdown-item>
            <x-dropdown-item
                href="{{ route('screenshot-hub.index', ['desc' => $desc, 'orderBy' => $orderBy, 'range' => 'year']) }}"
                :active="($range === 'year')">
                One Year
            </x-dropdown-item>
        </x-dropdown>
    </div>

    <div class="ml-3">
        <x-dropdown title="Order By">
            <x-dropdown-item
                href="{{ route('screenshot-hub.index', ['range' => $range, 'desc' => $desc, 'orderBy' => 'created_at']) }}"
                :active="($orderBy === 'created_at')">
                Submitted At
            </x-dropdown-item>
            <x-dropdown-item
                href="{{ route('screenshot-hub.index', ['range' => $range, 'desc' => $desc, 'orderBy' => 'votes_count']) }}"
                :active="($orderBy === 'votes_count')">
                Votes
            </x-dropdown-item>
        </x-dropdown>
    </div>

    <div class="ml-3">
        <a class="relative inline-flex items-center px-2 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
           href="{{ route('screenshot-hub.index', ['range' => $range, 'orderBy' => $orderBy, 'desc' => !$desc]) }}">
            @if(!$desc)
                <span class="sr-only">Descending</span>
                <x-heroicon-o-sort-descending class="h-5 w-5"/>
            @else
                <span class="sr-only">Ascending</span>
                <x-heroicon-o-sort-ascending class="h-5 w-5"/>
            @endif
        </a>
    </div>

    <div class="ml-3">
        <a href="{{ route('screenshot-hub.create') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5"/>
            New Screenshot
        </a>
    </div>
@endsection

<div>
    <x-alert/>

    @if($screenshots->count())
        <ul class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:grid-cols-3 lg:gap-x-8">
            @foreach($screenshots as $screenshot)
                <li>
                    <div class="space-y-4">
                        <a href="{{ route('screenshot-hub.show', $screenshot) }}">
                            <div class="aspect-w-3 aspect-h-2">
                                <img class="object-cover shadow-lg rounded-lg"
                                     src="{{ $screenshot->image_url }}" alt="{{ $screenshot->description }}">
                            </div>
                        </a>

                        <div class="space-y-2">
                            <div class="text-lg leading-6 font-medium space-y-0.5">
                                <a href="{{ route('screenshot-hub.show', $screenshot) }}">
                                    <h3>{{ $screenshot->title }}</h3>
                                </a>

                                <p class="text-sm">
                                    By
                                    @if($screenshot->user)
                                        <a class="text-indigo-600"
                                           href="{{ route('users.profile', $screenshot->user) }}">
                                            {{ $screenshot->user->username }}
                                        </a>
                                    @else
                                        <span class="text-indigo-600">
                                            Unknown User
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <ul class="flex flex-row space-x-2 text-sm">
                                <a class="text-red-500" href="{{ route('screenshot-hub.toggleVote', $screenshot) }}">
                                    <span class="sr-only">Votes</span>
                                    @if($screenshot->votes()->where('user_id', Auth::id())->exists())
                                        <x-heroicon-s-heart class="w-5 h-5"/>
                                    @else
                                        <x-heroicon-o-heart class="w-5 h-5"/>
                                    @endif
                                </a>
                                <span>
                                    {{ $screenshot->votes_count }} {{ Str::plural('vote', $screenshot->votes_count) }}
                                </span>
                            </ul>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state :image="asset('img/illustrations/empty.svg')"
                       alt="Empty illustration">
            Hmm, it looks like there are no screenshots yet.
            <br>
            Why don't you upload one?
        </x-empty-state>
    @endif
</div>
