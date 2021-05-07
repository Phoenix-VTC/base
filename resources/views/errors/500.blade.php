@extends('errors::illustrated-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    <strong>
        Sorry, there were some technical issues while processing your request.
    </strong>
    <br>
    We are currently trying to fix the problem.
    <br><br>
    In the meantime, you can try refreshing the page.
@endsection

@section('head')
    <script
        src="https://browser.sentry-cdn.com/5.29.2/bundle.min.js"
        integrity="sha384-ir4+BihBClNpjZk3UKgHTr0cwRhujAjy/M5VEGvcOzjhM1Db79GAg9xLxYn4uVK4"
        crossorigin="anonymous">
    </script>
@endsection

@section('content')
    @if(app()->bound('sentry') && app('sentry')->getLastEventId())
        <div class="subtitle">Error ID: {{ app('sentry')->getLastEventId() }}</div>
        <script>
            Sentry.init({dsn: 'https://dc50d9a4831941e0811e66ef2780dd30@o105402.ingest.sentry.io/1548112'});
            Sentry.showReportDialog({
                eventId: '{{ app('sentry')->getLastEventId() }}',
                @auth
                    user: {
                        name: '{{ Auth::user()->username }}',
                        email: '{{ Auth::user()->email }}'
                    }
                @endauth
            });
        </script>
    @endif
@endsection
