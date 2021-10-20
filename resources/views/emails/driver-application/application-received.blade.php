{{-- Do NOT indent this code, otherwise the markdown breaks. --}}

@component('mail::message')
# Driver application received

Hey {{ $application->username }}!

Thanks for applying to PhoenixVTC.
<br>
We have successfully received your application, and you should receive an answer from one of our Human Resource team members within 12 hours.

@component('mail::button', ['url' => route('driver-application.status', $application->uuid)])
View application status
@endcomponent

Good luck, and maybe we'll see you on the road soon!

Thanks, <br>
The Phoenix Team
@endcomponent
