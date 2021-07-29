{{-- If your happiness depends on money, you will never be happy with yourself. --}}

@section('title', 'My notifications')

@section('actions')
    <div class="ml-3">
        <a href="{{ route('notifications.markAllAsRead') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-check class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            Mark all as read
        </a>
    </div>
@endsection

<div class="space-y-5">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Unread notifications
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                @forelse(Auth::user()->unreadNotifications as $notification)
                    <li class="relative bg-white py-5 px-4 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                        <form class="flex justify-between" method="POST"
                              action="{{ route('notifications.markAsRead', $notification->id) }}">
                            @csrf
                            <div class="min-w-0 flex-1">
                                <button type="submit"
                                        class="text-sm font-semibold text-gray-800 hover:underline focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    {{ $notification->data['title'] ?? '' }}
                                </button>
                            </div>
                            <time datetime="2021-01-27T16:35"
                                  class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                                {{ $notification->created_at->diffForHumans(['short' => true]) }}
                            </time>
                        </form>
                        <div class="mt-1">
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                {{ $notification->data['content'] ?? '' }}
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="relative bg-white py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                        <p class="line-clamp-2 text-sm text-gray-600">
                            You don't have any unread notifications!
                        </p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                All notifications
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                @forelse(Auth::user()->notifications as $notification)
                    <li class="relative @if(is_null($notification->read_at)) bg-white hover:bg-gray-50 @else bg-gray-100 hover:bg-gray-200 @endif py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                        <form class="flex justify-between" method="POST"
                              action="{{ route('notifications.markAsRead', $notification->id) }}">
                            @csrf
                            <div class="min-w-0 flex-1">
                                <button type="submit"
                                        class="text-sm font-semibold text-gray-800 hover:underline focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    {{ $notification->data['title'] ?? '' }}
                                </button>
                            </div>
                            <time datetime="2021-01-27T16:35"
                                  class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                                {{ $notification->created_at->diffForHumans(['short' => true]) }}
                            </time>
                        </form>
                        <div class="mt-1">
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                {{ $notification->data['content'] ?? '' }}
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="relative bg-white py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                        <p class="line-clamp-2 text-sm text-gray-600">
                            You don't have any unread notifications!
                        </p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
