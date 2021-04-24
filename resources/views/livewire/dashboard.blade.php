@section('title', 'Hi, ' . Auth::user()->username . '!')

<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        Last 30 days
    </h3>

    <dl class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

        <livewire:jobs.components.statistic
            icon="o-clipboard-list"
            title="Deliveries"
            :content="$stats['delivery_count']['current_month']"
            :change-number="abs($stats['delivery_count']['previous_month'] - $stats['delivery_count']['current_month'])"
            :increased="($stats['delivery_count']['current_month'] > $stats['delivery_count']['previous_month'])"
        />

        <livewire:jobs.components.statistic
            icon="o-currency-euro"
            title="Income"
            content="{!! Auth::user()->preferred_currency_symbol !!} {{ number_format($stats['income']['current_month']) }}"
            :change-number="number_format(abs($stats['income']['previous_month'] - $stats['income']['current_month']))"
            :increased="($stats['income']['current_month'] > $stats['income']['previous_month'])"
        />

        <livewire:jobs.components.statistic
            icon="o-truck"
            title="Distance"
            content="{{ number_format($stats['distance']['current_month']) }} {{ Auth::user()->preferred_distance_abbreviation }}"
            :change-number="number_format(abs($stats['distance']['previous_month'] - $stats['distance']['current_month']))"
            :increased="($stats['distance']['current_month'] > $stats['distance']['previous_month'])"
        />

    </dl>
</div>
