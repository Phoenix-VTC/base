@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('content')
    <script>plausible("404", { props: { path: document.location.pathname } });</script>
@endsection
