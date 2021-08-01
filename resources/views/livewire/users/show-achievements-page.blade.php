{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', "$user->username's achievements")

@section('actions')
    <div class="ml-3">
        <a href="{{ route('users.profile', $user->id) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-s-identification class="-ml-1 mr-2 h-5 w-5 text-gray-500"/>
            View {{ $user->username }}'s profile
        </a>
    </div>
@endsection

<div>
    <section aria-labelledby="achievements-title" class="lg:col-start-3 lg:col-span-1">
        <div class="bg-white py-5 shadow sm:rounded-lg">
            <h2 id="achievements-title" class="text-lg font-medium text-gray-900 px-4 sm:px-6">
                Unlocked Achievements
            </h2>

            <div class="flow-root mt-6">
                <ul class="-my-5 divide-y divide-gray-200">
                    @foreach($achievements as $achievement)
                        <div class="px-4 sm:px-6 @if(!$achievement->unlocked_at) bg-gray-200 @endif">
                            <li class="py-5">
                                <div class="flex justify-between">
                                    <div class="min-w-0 flex-1">
                                        <span class="text-sm font-semibold text-gray-800 focus:outline-none">
                                            {{ $achievement->details->name }}
                                        </span>
                                    </div>
                                    @if($achievement->unlocked_at)
                                        <time datetime="2021-01-27T16:35"
                                              class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
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
                                                <div class="bg-white rounded h-6 mt-5" role="progressbar"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"
                                                     aria-valuenow="{{ $achievement->points / $achievement->details->points * 100 }}">
                                                    <div
                                                        class="bg-green-400 rounded h-6 text-center text-black text-sm"
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
