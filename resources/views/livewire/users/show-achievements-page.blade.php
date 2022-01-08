{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', "$user->username's achievements")

@section('actions')
    <div class="ml-3">
        <a href="{{ route('users.profile', $user) }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-identification class="w-5 h-5 mr-2 -ml-1 text-gray-500"/>
            View {{ $user->username }}'s profile
        </a>
    </div>
@endsection

<div>
    <section aria-labelledby="achievements-title" class="lg:col-start-3 lg:col-span-1">
        <div class="py-5 bg-white shadow sm:rounded-lg">
            <h2 id="achievements-title" class="px-4 text-lg font-medium text-gray-900 sm:px-6">
                Unlocked Achievements
            </h2>

            <div class="flow-root mt-6">
                <ul class="-my-5 divide-y divide-gray-200">
                    @foreach($achievements as $achievement)
                        <div class="px-4 sm:px-6 @if(!$achievement->unlocked_at) bg-gray-200 @endif">
                            <li class="py-5">
                                <div class="flex justify-between">
                                    <div class="flex-1 min-w-0">
                                        <span class="text-sm font-semibold text-gray-800 focus:outline-none">
                                            {{ $achievement->details->name }}
                                        </span>
                                    </div>
                                    @if($achievement->unlocked_at)
                                        <time datetime="2021-01-27T16:35"
                                              class="flex-shrink-0 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $achievement->unlocked_at->diffForHumans() }}
                                        </time>
                                    @endif
                                </div>

                                <div class="mt-1">
                                    <div class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        @if($achievement->unlocked_at)
                                            <span>{{ $achievement->details->description }}</span>
                                        @else
                                            Not yet unlocked
                                            @if($achievement->points > 0)
                                                <div class="h-6 mt-5 bg-white rounded" role="progressbar"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"
                                                     aria-valuenow="{{ $achievement->points / $achievement->details->points * 100 }}">
                                                    <div
                                                        class="h-6 text-sm text-center text-black bg-green-400 rounded"
                                                        style="width: {{ $achievement->points / $achievement->details->points * 100 . '%' }}; transition: width 2s;">
                                                        {{ $achievement->points / $achievement->details->points * 100 . '%' }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</div>
