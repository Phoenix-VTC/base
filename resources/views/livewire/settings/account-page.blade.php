{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

@section('title', 'Settings')

<div>
    <x-alert/>

    <div class="w-full p-4 m-4 bg-blue-200 rounded-md" wire:loading wire:target="profile_picture, profile_banner">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500"/>
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

    <div class="overflow-hidden bg-white rounded-lg shadow">
        <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
            {{-- Added a wire:ignore here, otherwise the sidebar item active state breaks when choosing a radio button. Wot? --}}
            <aside class="py-6 lg:col-span-3" wire:ignore>
                <x-settings.sidebar/>
            </aside>

            <form class="divide-y divide-gray-200 lg:col-span-9" wire:submit.prevent="submit">
                <div class="px-4 py-6 sm:p-6 lg:pb-8">
                    <div>
                        <h2 class="text-lg font-medium leading-6 text-gray-900">Profile Settings</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Change your profile and account settings.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <x-input.group label="Profile Picture" for="profile_picture"
                                       :error="$errors->first('profile_picture')" col-span="6">
                            <div class="flex items-center mt-1">
                                <img class="inline-block w-12 h-12 rounded-full"
                                     @if ($profile_picture)
                                     src="{{ $profile_picture->temporaryUrl() }}"
                                     @else
                                     src="{{ $user->profile_picture }}"
                                     @endif
                                     alt="Your profile picture" height="48" width="48">
                                <div class="flex ml-4">
                                    <div
                                        class="relative flex items-center px-3 py-2 bg-white border rounded-md shadow-sm cursor-pointer border-blue-gray-300 hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                        <label for="profile_picture"
                                               class="relative text-sm font-medium pointer-events-none text-blue-gray-900">
                                            <span>Change</span>
                                            <span class="sr-only"> profile picture</span>
                                        </label>
                                        <input id="profile_picture" name="profile_picture" type="file"
                                               wire:model.lazy="profile_picture" accept=".jpg,.jpeg,.png"
                                               class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                    </div>
                                    @if($user->profile_picture_path)
                                        <button type="button" wire:click="removeProfilePicture"
                                                onclick="confirm('Are you sure you want to remove your profile picture?') || event.stopImmediatePropagation()"
                                                class="px-3 py-2 ml-3 text-sm font-medium bg-transparent border border-transparent rounded-md text-blue-gray-900 hover:text-blue-gray-700 focus:outline-none focus:border-blue-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-gray-50 focus:ring-blue-500">
                                            Remove
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </x-input.group>

                        <x-input.group label="Profile Banner" for="profile_banner"
                                       :error="$errors->first('profile_banner')" col-span="6">
                            <div
                                class="w-full h-40 pb-6 mt-1 overflow-hidden bg-white rounded-lg shadow-sm md:max-w-sm">
                                <div class="relative">
                                    <img class="absolute object-cover w-full h-40"
                                         @if ($profile_banner)
                                         src="{{ $profile_banner->temporaryUrl() }}"
                                         @else
                                         src="{{ $user->profile_banner }}"
                                         @endif
                                         alt="Your Profile Banner" height="384" width="160">
                                </div>
                            </div>

                            <div class="flex mt-4">
                                <div
                                    class="relative flex items-center px-3 py-2 bg-white border rounded-md shadow-sm cursor-pointer border-blue-gray-300 hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                    <label for="profile_picture"
                                           class="relative text-sm font-medium pointer-events-none text-blue-gray-900">
                                        <span>Change</span>
                                        <span class="sr-only"> profile banner</span>
                                    </label>
                                    <input id="profile_banner" name="profile_banner" type="file"
                                           wire:model.lazy="profile_banner" accept=".jpg,.jpeg,.png"
                                           class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                </div>
                                @if($user->profile_banner_path)
                                    <button type="button" wire:click="removeProfileBanner"
                                            onclick="confirm('Are you sure you want to remove your profile banner?') || event.stopImmediatePropagation()"
                                            class="px-3 py-2 ml-3 text-sm font-medium bg-transparent border border-transparent rounded-md text-blue-gray-900 hover:text-blue-gray-700 focus:outline-none focus:border-blue-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-gray-50 focus:ring-blue-500">
                                        Remove
                                    </button>
                                @endif
                            </div>
                        </x-input.group>
                    </div>
                </div>

                <div class="px-4 py-6 sm:p-6 lg:pb-8">
                    <div>
                        <h2 class="text-lg font-medium leading-6 text-gray-900">Account Settings</h2>
                    </div>

                    <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <x-input.group label="Username" for="username" :error="$errors->first('username')" col-span="3">
                            <x-input.text wire:model.lazy="username" type="text" id="username"
                                          :error="$errors->first('username')" autocomplete="username"/>
                        </x-input.group>

                        <x-input.group label="Email" for="email" :error="$errors->first('email')" col-span="3">
                            <x-input.text wire:model.lazy="email" type="email" id="email"
                                          :error="$errors->first('email')" autocomplete="email"/>
                        </x-input.group>

                        <x-input.group label="Slug" for="slug" :error="$errors->first('slug')" col-span="3"
                            help-text="{{ url()->route('profile.fancy-redirect', $slug) }}">
                            <x-input.text wire:model.lazy="slug" type="text" id="slug"
                                          :error="$errors->first('slug')"/>
                        </x-input.group>

                        <x-input.group label="Steam ID" for="steam_id" col-span="3"
                                       help-text="Contact a staff member in order to change this.<br><a href='https://steamcommunity.com/profiles/{{ $user->steam_id }}' target='_blank'>View Steam Profile</a>">
                            <x-input.text wire:model.lazy="steam_id" type="text" id="steam_id" class="bg-gray-100"
                                          disabled/>
                        </x-input.group>

                        <x-input.group label="TruckersMP ID" for="truckersmp_id" col-span="3"
                                       help-text="Contact a staff member in order to change this.<br><a href='https://truckersmp.com/user/{{ $user->truckersmp_id }}' target='_blank'>View TruckersMP Profile</a>">
                            <x-input.text wire:model.lazy="truckersmp_id" type="text" id="truckersmp_id"
                                          class="bg-gray-100" disabled/>
                        </x-input.group>

                        <x-input.group label="Date of Birth" for="date_of_birth"
                                       col-span="3" help-text="Contact a staff member in order to change this.">
                            <x-input.text wire:model="date_of_birth" type="date" id="date_of_birth" class="bg-gray-100"
                                          disabled/>
                        </x-input.group>
                    </div>
                </div>

                <div class="flex justify-end px-4 py-4 mt-4 sm:px-6">
                    <button type="submit"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-orange-600 border border-transparent rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


