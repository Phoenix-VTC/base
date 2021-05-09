{{-- Nothing in the world is as soft and yielding as water. --}}

@section('title', 'Edit Download')

@section('description', 'Keep the file inputs empty if you don\'t want to change the files.')

<div>
    <x-alert/>

    <div class="rounded-md bg-blue-200 p-4 m-4 w-full" wire:loading wire:target="image, file, submit">
        <div class="flex">
            <div class="flex-shrink-0">
                {{-- information-circle --}}
                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3 text-blue-800">
                <h3 class="mb-2 text-sm font-bold">
                    Please wait
                </h3>
                <p class="text-sm font-medium">
                    Your files are being uploaded.
                </p>
            </div>
        </div>
    </div>

    <form class="space-y-8 divide-y divide-gray-200" wire:submit.prevent="submit">
        <div class="space-y-8 divide-y divide-gray-200">
            <div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <x-input.group label="Name" for="name" :error="$errors->first('name')">
                        <x-input.text wire:model.lazy="name" type="text" id="name" autocomplete="off" required
                                      :error="$errors->first('name')" placeholder="Kenji Tuning Mod"/>
                    </x-input.group>

                    <x-input.group label="Thumbnail Image (max 1MB)" for="image" :error="$errors->first('image')">
                        <x-input.text wire:model.lazy="image" type="file" id="image" accept=".jpg,.jpeg,.png,.bmp,.gif,.svg,.webp"
                                      :error="$errors->first('image')"/>
                    </x-input.group>

                    <x-input.group label="File (max 100MB)" for="file" :error="$errors->first('file')" help-text="Allowed file types: <strong>PDF, ZIP, RAR, SCS</strong><br>SCS will be automatically converted to ZIP">
                        <x-input.text wire:model.lazy="file" type="file" id="file" accept=".pdf,.zip,.rar,.scs"
                                      :error="$errors->first('file')"/>
                    </x-input.group>

                    <x-input.group label="Description (optional)" for="description" :error="$errors->first('description')">
                        <x-input.textarea wire:model.lazy="description" type="text" id="name" rows="3" :error="$errors->first('description')"/>
                    </x-input.group>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('downloads.management.index') }}"
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
