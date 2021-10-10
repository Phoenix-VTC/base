{{-- Do NOT indent this code, otherwise the markdown breaks. --}}

@component('mail::message')
# Your driver application status

Hey {{ $application->username }}!

Thank you for applying to join PhoenixVTC!
<br>
Unfortunately on this occasion, your application has been denied.
For any additional information about this decision, you can contact our Human Resources team at [hr@phoenixvtc.com](mailto:hr@phoenixvtc.com)

If you meet our entry requirements, you’re welcome to re-apply after 1 week!

Thank you, <br>
The Phoenix Team
@endcomponent
