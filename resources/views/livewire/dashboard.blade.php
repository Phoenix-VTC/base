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
@endsection
