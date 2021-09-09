{{-- Do NOT indent this code, otherwise the markdown breaks. --}}

@component('mail::message')
# Welcome to the team, {{ $user->username }}!

We are very happy to share with you that have been accepted into PhoenixVTC!

As a next step, please also **[apply to our TruckersMP page](https://truckersmp.com/vtc/30294)**. The application text can be something simple like "I already am a member of Phoenix". This is just to finalize your application process.

To activate your {{ config('app.name') }} account, please press the button below.

@component('mail::button', ['url' => route('welcome', $user->welcome_token)])
Choose password
@endcomponent

Congratulations, and we're hoping to see you on the road soon!

Thanks, <br>
The Phoenix Team

<br>
<strong><small>Please note that the choose password link expires on {{ $user->welcome_valid_until }}</small></strong>
@endcomponent
