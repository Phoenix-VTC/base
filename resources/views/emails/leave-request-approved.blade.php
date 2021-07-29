{{-- Do NOT indent this code, otherwise the markdown breaks. --}}

@component('mail::message')
# We're sad to see you go, {{ $user->username }}.

Your request to leave Phoenix has been approved.

If there is anything else we can do for you, please don't be afraid to reach out to us.

Thanks and take care, <br>
The Phoenix Team
@endcomponent
