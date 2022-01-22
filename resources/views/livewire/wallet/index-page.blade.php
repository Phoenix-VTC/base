{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day --}}

@section('title', 'My Wallet')

@section('description', 'Showing the 30 most recent transactions.')

@section('meta')
    <x-header.meta-item icon="o-cash">
        {!! $user->preferred_currency_symbol !!} {{ number_format($user->default_wallet_balance) }}
    </x-header.meta-item>

    <x-header.meta-item icon="o-briefcase">
        {{ number_format($user->getWallet('job-xp')->balance ?? 0) }} Job XP
    </x-header.meta-item>

    <x-header.meta-item icon="o-star">
        {{ number_format($user->getWallet('event-xp')->balance ?? 0) }} Event XP
    </x-header.meta-item>

    <x-header.meta-item icon="o-calculator">
        Total XP: {{ number_format($user->totalDriverPoints()) }}
    </x-header.meta-item>
@endsection

<div>
    <x-alert/>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 space-y-6">
                @empty(!$user->wallets->count())
                    @foreach($user->wallets->take(10) as $wallet)
                        <div>
                            <h2 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $wallet->name }}
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-sm font-medium bg-blue-100 text-blue-800">
                                    Total: @if(!Str::contains($wallet->slug, 'xp'))&euro; @endif
                                    {{ $wallet->balance }}
                                </span>
                            </h2>
                            <div class="flex flex-col mt-3">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Type
                                                    </th>

                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Amount
                                                    </th>

                                                    @if($wallet->slug === 'event-xp')
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Event Name
                                                        </th>
                                                    @endif

                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Description
                                                    </th>

                                                    @if($wallet->slug === 'default')
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Job ID
                                                        </th>
                                                    @endif

                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Created At
                                                    </th>

                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Updated At
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($wallet->transactions->where('wallet_id', $wallet->id)->SortByDesc('created_at')->take(30) as $transaction)
                                                    <tr class="@if($loop->odd) bg-white @else bg-gray-50 @endif font-medium">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            @switch($transaction->type)
                                                                @case('deposit')
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ ucwords($transaction->type) }}
                                                            </span>
                                                                @break
                                                                @case('withdraw')
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                {{ ucwords($transaction->type) }}
                                                            </span>
                                                                @break
                                                                @default
                                                                <span
                                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                {{ ucwords($transaction->type) }}
                                                            </span>
                                                            @endswitch
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            @if(!Str::contains($wallet->slug, 'xp'))
                                                            &euro;
                                                            @endif
                                                            {{ $transaction->amount }}
                                                        </td>

                                                        @if($wallet->slug === 'event-xp')
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $transaction->meta['event_name'] ?? 'Unknown' }}
                                                            </td>
                                                        @endif

                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction->meta['description'] ?? null }}
                                                        </td>

                                                        @if($wallet->slug === 'default')
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $transaction->meta['job_id'] ?? 'Unknown' }}
                                                            </td>
                                                        @endif

                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction->created_at }}
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction->updated_at }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <x-empty-state :image="asset('img/illustrations/wallet.svg')"
                                   alt="Wallet illustration">
                        Hmm, it looks like you don't have any wallets yet.
                        <br>
                        Go submit some jobs and/or attend some events, and your income will show up here!
                    </x-empty-state>
                @endif
            </div>
        </div>
    </div>
</div>
