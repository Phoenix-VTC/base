@if (session()->has('alert'))
    @php
        if (in_array(session('alert.type'), ['danger', 'success', 'warning',])) {
            $type = session('alert.type');
        } else {
            $type =  'primary';
        }

        switch($type) {
            case 'warning':
            case 'danger':
                $icon = 'iconic-warning-triangle';
                break;
            case 'success':
                $icon = 'iconic-check-circle';
                break;
            default:
                $icon = 'iconic-information';
        }
    @endphp

    <x-app-ui::alert :icon="$icon" :color="$type" class="mb-4">
        @if(session('alert.title'))
            <x-slot name="heading">
                {{ session('alert.title') }}
            </x-slot>
        @endif

        {!! session('alert.message') !!}
    </x-app-ui::alert>
@endif
