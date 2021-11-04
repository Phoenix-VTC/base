{{-- In work, do what you enjoy. --}}

@section('title', 'Settings')

<div>
    <x-alert/>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
            {{-- Added a wire:ignore here, otherwise the sidebar item active state breaks when choosing a radio button. Wot? --}}
            <aside class="py-6 lg:col-span-3" wire:ignore>
                <x-settings.sidebar/>
            </aside>

            <form class="divide-y divide-gray-200 lg:col-span-9" wire:submit.prevent="submit">
                <div class="py-6 px-4 sm:p-6 lg:pb-8">
                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Security Settings</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Change your account password.
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <x-input.group label="Old Password" for="old_password" :error="$errors->first('old_password')"
                                       col-span="3">
                            <x-input.text wire:model.lazy="old_password" type="password" id="old_password"
                                          :error="$errors->first('old_password')" autocomplete="current-password"
                                          required/>
                        </x-input.group>

                        <br>

                        <x-input.group label="New Password" for="new_password" :error="$errors->first('new_password')"
                                       col-span="3">
                            <x-input.text wire:model.lazy="new_password" type="password" id="new_password"
                                          :error="$errors->first('new_password')" autocomplete="new-password" required/>
                        </x-input.group>

                        <x-input.group label="Confirm New Password" for="new_password_confirmation" :error="$errors->first('new_password_confirmation')"
                                       col-span="3">
                            <x-input.text wire:model.lazy="new_password_confirmation" type="password"
                                          id="new_password_confirmation"
                                          :error="$errors->first('new_password_confirmation')" autocomplete="new-password" required/>
                        </x-input.group>
                    </div>
                </div>

                <div class="py-6 px-4 sm:p-6 lg:pb-8">
                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Tracker Token</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            This token is required in order to communicate with our Tracker API.
                            <br>
                            <span>
                                Make sure to keep this token safe, and <b>never</b> share it with anyone.
                            </span>
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        @if(Auth::user()->tokens()->where('name', 'tracker-token')->count())
                            <x-input.group label="Token"
                                           help-text="Tokens can only be viewed once. Need it again? Please regenerate it."
                                           for="tracker_token" col-span="5">
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <x-heroicon-s-finger-print class="h-5 w-5 text-gray-400"/>
                                        </div>
                                        <input
                                            class="focus:ring-indigo-500 border focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300"
                                            id="tracker_token" type="text" onClick="this.select();"
                                            wire:model.lazy="tracker_token" readonly>
                                    </div>
                                    <button
                                        class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                        type="button" wire:click="generateTrackerToken"
                                        onclick="confirm('Are you sure you that you want to regenerate your tracker token?') || event.stopImmediatePropagation()">
                                        <x-heroicon-s-refresh class="h-5 w-5 text-gray-400"/>
                                        <span>
                                            Regenerate
                                        </span>
                                    </button>
                                </div>
                            </x-input.group>

                            <x-input.group label="" col-span="5">
                                <button
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm"
                                    type="button" wire:click="revokeTrackerToken"
                                    onclick="confirm('Are you sure you that you want to revoke your tracker token?') || event.stopImmediatePropagation()">
                                    Revoke token
                                </button>
                            </x-input.group>
                        @else
                            <x-input.group label="" col-span="5">
                                <button
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:w-auto sm:text-sm"
                                    type="button" wire:click="generateTrackerToken">
                                    Generate token
                                </button>
                            </x-input.group>
                        @endif
                    </div>
                </div>

                <div class="py-6 px-4 sm:p-6 lg:pb-8">
                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">API Tokens</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage all your API Tokens here.
                        </p>
                    </div>

                    <div class="flex flex-col mt-6">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Abilities
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Last Used At
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Created At
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Revoke</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse(Auth::user()->tokens as $token)
                                            <tr class="bg-white @if($loop->odd) bg-white @else bg-gray-50 @endif">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $token->name ?? 'Unknown Token' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @foreach($token->abilities as $ability)
                                                        <code>
                                                            {{ $ability }}
                                                        </code>
                                                        @if(!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if($token->last_used_at)
                                                        {{ $token->last_used_at->toDateTimeString() }}
                                                    @else
                                                        Never
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    @if($token->created_at)
                                                        {{ $token->created_at->toDateTimeString() }}
                                                    @else
                                                        Unknown Date
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button class="text-red-600 hover:text-red-900" type="button"
                                                            wire:click="revokeApiToken({{ $token->id }})"
                                                            onclick="confirm('Are you sure you that you want to revoke this token?') || event.stopImmediatePropagation()">
                                                        Revoke
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                You currently don't have any active API Tokens.
                                            </td>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if(Auth::user()->tokens()->count())
                            <x-input.group label="" col-span="5" class="mt-6">
                                <button
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm"
                                    type="button" wire:click="revokeAllApiTokens"
                                    onclick="confirm('Are you sure you that you want to revoke all tokens?') || event.stopImmediatePropagation()">
                                    Revoke all tokens
                                </button>
                            </x-input.group>
                        @endif
                    </div>

                </div>

                <div class="mt-4 py-4 px-4 flex justify-end sm:px-6">
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
