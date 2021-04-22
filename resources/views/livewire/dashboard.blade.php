@extends('layouts.app')

@section('title', 'Hi, ' . Auth::user()->username . '!')

@section('content')
    <div class="py-4 prose">
        <p>
            Welcome to PhoenixBase
        </p>

        <p>
            There's nothing here for now, but new features are in development!
        </p>

        <p>
            To log jobs we're using TrucksBook for now. You can join the Phoenix company here:
            <a target="_blank" href="https://trucksbook.eu/company/100008">https://trucksbook.eu/company/100008</a>
        </p>

        <p>
            You'll also need to apply to join our TruckersMP VTC, which you can do here:
            <a target="_blank" href="https://truckersmp.com/vtc/30294">https://truckersmp.com/vtc/30294</a>
        </p>
    </div>

{{--    <div>--}}
{{--        <h3 class="text-lg leading-6 font-medium text-gray-900">--}}
{{--            Last 30 days--}}
{{--        </h3>--}}

{{--        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">--}}

{{--            <livewire:jobs.components.statistic icon="o-clipboard-list" title="Deliveries" content="104" change-number="12"/>--}}

{{--            <livewire:jobs.components.statistic icon="o-currency-euro" title="Income" content="15526" change-number="500" :increased="false"/>--}}

{{--            <livewire:jobs.components.statistic icon="o-truck" title="Distance" content="15526" change-number="500" :increased="false"/>--}}

{{--        </dl>--}}
{{--    </div>--}}
@endsection
