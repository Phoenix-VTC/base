{{-- The Master doesn't talk, he acts. --}}

@section('title', 'Social Connections')

<div>
    <x-alert/>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200 lg:grid lg:grid-cols-12 lg:divide-y-0 lg:divide-x">
            {{-- Added a wire:ignore here, otherwise the sidebar item active state breaks when choosing a radio button. Wot? --}}
            <aside class="py-6 lg:col-span-3" wire:ignore>
                <x-settings.sidebar/>
            </aside>

            <div class="divide-y divide-gray-200 lg:col-span-9">
                <form class="py-6 px-4 sm:p-6 lg:pb-8" action="{{ route('auth.discord.redirectToDiscord') }}"
                      method="POST">
                    @csrf

                    <div>
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Discord</h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Connect your Discord account here.
                            <br>
                            You can also use this to log in to your PhoenixBase account.
                        </p>
                    </div>

                    @if(!is_null($user->discord))
                        <div class="py-4 flex">
                            <img class="h-10 w-10 rounded-full"
                                 src="{{ $user->discord['avatar'] }}"
                                 alt="{{ $user->discord['name'] }}'s profile picture">
                            <div class="ml-3 flex flex-col">
                                <span class="text-sm font-medium text-gray-900">{{ $user->discord['nickname'] }}</span>
                                <span class="text-sm text-gray-500">{{ $user->discord['id'] }}</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm">
                                Reconnect
                            </button>
                        </div>
                    @else
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm">
                                Connect
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
