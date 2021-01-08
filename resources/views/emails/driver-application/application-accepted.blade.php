{{-- Do NOT indent this code, otherwise the markdown breaks. --}}

@component('mail::message')
# Welcome to the team, {{ $user->username }}!

We are very happy to share with you that have been accepted into PhoenixVTC!

To activate your {{ config('app.name') }} account, please press the button below.

{{--@component('mail::button', ['url' => route('driver-application.status', $user->id)])--}}
{{--Choose password--}}
{{--@endcomponent--}}

Congratulations, and we're hoping to see you on the road soon!

Thanks, <br>
The Phoenix Team
@endcomponent
