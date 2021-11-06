{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

<div>
    <form wire:submit.prevent="submit">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 break-words">
            <div class="sm:flex sm:items-start">
                <div
                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                    <x-heroicon-o-user-add class="h-6 w-6 text-green-600"/>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Accept applicant (<b>{{ $application->username }}</b>)
                    </h3>

                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            In order to successfully process this application, please provide the applicant's Discord ID in order to add their Phoenix Member role, and post the welcome message.
                        </p>
                    </div>

                    <div class="mt-2 w-full">
                        <x-input.group label="Discord ID" for="reason" :error="$errors->first('discord_id')">
                            <x-input.text wire:model.lazy="discord_id" type="number" id="discord_id" autocomplete="off" required
                                          :error="$errors->first('discord_id')" placeholder="112928994340384768"/>
                        </x-input.group>
                    </div>

                    <div class="mt-4">
                        <x-alert/>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                Accept
            </button>
            <button type="button" wire:click="$emit('closeModal')"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
        </div>
    </form>
</div>

