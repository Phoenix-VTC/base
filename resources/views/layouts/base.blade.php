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
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180"
          href="{{ asset('img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{ asset('img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{ asset('img/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('img/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="shortcut icon" href="{{ asset('img/favicons/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    <meta name="theme-color" content="#18181B">
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
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ url(mix('js/app.js')) }}" defer></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('scripts')
</head>

<body>
@yield('body')

@livewireScripts
</body>
</html>
