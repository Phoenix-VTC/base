<section aria-labelledby="staff-comments-title">
    <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
        <div class="divide-y divide-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <h2 id="staff-comments-title" class="text-lg font-medium text-gray-900">
                    Staff Comments
                </h2>
            </div>
            <div class="px-4 py-6 sm:px-6">
                <ul class="space-y-8">
                    @foreach($application->comments as $comment)
                        <li>
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                         src="{{ $comment->user->profile_picture }}"
                                         alt="">
                                </div>
                                <div>
                                    <div class="text-sm">
                                        <a href="#" class="font-medium text-gray-900">{{ $comment->user->username }}</a>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>{{ $comment->body }}</p>
                                    </div>
                                    <div class="mt-2 text-sm space-x-2">
                                        <span class="text-gray-500 font-medium">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                        @can('delete', $comment)
                                            <span class="text-gray-500 font-medium">&middot;</span>
                                            <button type="button" wire:click="deleteComment('{{ $comment->uuid }}')"
                                                    class="text-gray-900 font-medium">
                                                Delete
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    @empty($application->comments->count())
                        No comments yet
                    @endempty
                </ul>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-6 sm:px-6">
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                         src="{{ Auth::user()->profile_picture }}"
                         alt="">
                </div>
                <div class="min-w-0 flex-1">
                    <form wire:submit.prevent="submitComment">
                        <div>
                            <label for="comment" class="sr-only">Comment</label>
                            <textarea id="comment" name="comment" rows="3" wire:model.lazy="comment"
                                      class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md @error('comment') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"
                                      placeholder="Add a comment"></textarea>
                        </div>
                        @error('comment')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                        <div class="mt-3 flex items-center justify-between">
                            <a href="#"
                               class="group inline-flex items-start text-sm space-x-2 text-gray-500 hover:text-gray-900">
                                <!-- Heroicon name: question-mark-circle -->
                                <svg
                                    class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span>These comments are not visible to the user.</span>
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
