@extends('layouts.base')

@push('scripts')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6GRVEBD26Y"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-6GRVEBD26Y');
    </script>
@endpush

@section('body')
    <div class="bg-gray-900">
        <div class="relative overflow-hidden">
            @include('components.events.navigation')

            <main>
                @yield('content')
            </main>

            @include('components.events.footer')
        </div>
    </div>
@endsection
