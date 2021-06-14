{{-- Be like water. --}}

@section('title', 'Screenshot Hub')

@section('description', 'Want to show off that sweet screenshot you took? This is the place to be!')

@section('actions')
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
                                <span class="text-red-500">
                                    <span class="sr-only">Likes</span>
                                    <x-heroicon-s-heart class="w-5 h-5"/>
                                </span>
                                <span>
                                    123 likes
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
