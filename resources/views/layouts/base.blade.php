<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('title')

        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    @laravelPWA
    <!-- Open Graph / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('dashboard') }}">
    <meta property="og:title" content="@yield('title') - {{ config('app.name') }}">
    <meta property="og:description"
          content="Phoenix is a brand-new VTC, founded by experienced members of the community. We believe in forward thinking, and strive to put our members first!">
    <meta property="og:locale" content="en_GB">
    <meta property="og:image"
          content="{{ asset('img/meta-image.png') }}">
    <!-- Twitter Meta Tags -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ route('dashboard') }}">
    <meta property="twitter:title" content="@yield('title') - {{ config('app.name') }}">
    <meta property="twitter:description"
          content="Phoenix is a brand-new VTC, founded by experienced members of the community. We believe in forward thinking, and strive to put our members first!">
    <meta property="twitter:site" content="@PhoenixVTC">
    <meta property="twitter:creator" content="@PhoenixVTC">
    <meta property="twitter:image"
          content="{{ asset('img/meta-image.png') }}">

    <!-- Fonts -->
    <link rel="preload" href="https://rsms.me/inter/inter.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://rsms.me/inter/inter.css"></noscript>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ url(mix('js/app.js')) }}" defer></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @production
        @auth
            <!-- Appzi: Capture Insightful Feedback -->
            <script async src="https://w.appzi.io/w.js?token=tb4V7"></script>
            <!-- End Appzi -->
        @endauth
    @endproduction

    @stack('scripts')
</head>

<body>
@yield('body')

@livewire('livewire-ui-modal')
@livewireScripts
</body>
</html>
