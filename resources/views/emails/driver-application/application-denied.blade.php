{{-- Do NOT indent this code, otherwise the markdown breaks. --}}

@component('mail::message')
# Your driver application status

Hey {{ $application->username }}!

Thank you for applying to join PhoenixVTC!
<br>
Unfortunately on this occasion, your application has been denied.
For any additional information about this decision, you can contact our Recruitment team at [recruitment@phoenixvtc.com](mailto:recruitment@phoenixvtc.com)

If you meet our entry requirements, you’re welcome to re-apply after 1 week!

Thanks, <br>
The Phoenix Team
@endcomponent
