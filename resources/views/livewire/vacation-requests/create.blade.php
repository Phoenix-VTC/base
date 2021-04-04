@section('title', 'New Vacation Request')

@section('description')
    Going away for a while, or do you want to leave Phoenix?
    <br>
    You can submit a vacation request here.
@endsection

<div>
    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
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

                    <div class="col-span-6 sm:col-span-3">
                        <label for="end_date"
                               class="block text-sm font-medium text-gray-700">
                            End Date
                        </label>
                        <input type="date" name="end_date" id="end_date"
                               wire:model.lazy="end_date" @if($leaving) disabled @endif
                               class="mt-1 w-full shadow-sm sm:text-sm border border-gray-300 rounded-md @if($leaving) bg-gray-200 @endif @error('end_date') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror">
                        <p class="mt-2 text-sm text-gray-500">
                            The end date must be at least one week after the start.
                            <br>
                            Not required if you're leaving Phoenix.
                        </p>
                        @error('end_date')
                        <p class="mt-2 text-sm text-red-600 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-6">
                        <label for="reason" class="block text-sm font-medium text-gray-700">
                            Reason
                        </label>
                        <textarea id="reason" name="reason" rows="3" x-ref="reason"
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

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('vacation-requests.index') }}"
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>
