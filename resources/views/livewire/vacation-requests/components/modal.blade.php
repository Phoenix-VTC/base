<div class="fixed z-10 inset-0 overflow-y-auto" x-show="showModal" x-cloak>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div x-show="showModal"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showModal" @click.away="showModal = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form wire:submit.prevent="submit">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                            {{-- clock --}}
                            <svg class="h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Submit new vacation request
                            </h3>
                            <div class="mt-4">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                                            Start Date
                                        </label>
                                        <input type="date" name="start_date" id="start_date"
                                               wire:model.lazy="start_date"
                                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('start_date') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                                        @error('start_date')
                                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3" x-show="@entangle('leaving')">
                                        <label for="end_date"
                                               class="block text-sm font-medium text-gray-700">
                                            End Date
                                        </label>
                                        <input type="date" name="end_date" id="end_date"
                                               wire:model.lazy="end_date" @if($leaving) disabled @endif
                                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @if($leaving) bg-gray-100 @endif @error('end_date') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                                        <p class="mt-2 text-sm text-gray-500">
                                            Not required if you're leaving Phoenix
                                        </p>
                                        @error('end_date')
                                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="reason" class="block text-sm font-medium text-gray-700">
                                            Reason
                                        </label>
                                        <textarea id="reason" name="reason" x-ref="reason"
                                                  wire:model.lazy="reason"
                                                  class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @error('reason') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                                                </textarea>
                                        @error('reason')
                                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <fieldset class="col-span-6">
                                        <legend class="text-base font-medium text-gray-900">
                                            Will you be leaving Phoenix?
                                        </legend>
                                        <p class="text-sm text-gray-500">
                                            Please note we are unable to re-activate accounts once they have
                                            been terminated.
                                        </p>
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-center">
                                                <input id="leaving_no" name="leaving"
                                                       type="radio" value="0"
                                                       wire:model.lazy="leaving"
                                                       class="focus:ring-green-500 h-4 w-4 text-green-600 border border-gray-300">
                                                <label for="leaving_no" class="ml-3">
                                                            <span
                                                                class="block text-sm font-medium text-gray-700">No</span>
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="leaving_yes" name="leaving" type="radio" value="1"
                                                       wire:model.lazy="leaving"
                                                       class="focus:ring-orange-500 h-4 w-4 text-orange-600 border border-gray-300">
                                                <label for="leaving_yes" class="ml-3">
                                                            <span
                                                                class="block text-sm font-medium text-gray-700">Yes</span>
                                                </label>
                                            </div>
                                        </div>
                                        @error('leaving')
                                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                                        @enderror
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Submit
                    </button>
                    <button type="button" @click="showModal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
