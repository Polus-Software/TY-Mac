@component('mail::message')

<h1>Hi {{ $details['instructorName']}},</h1>

Your <strong>live session {{ $details['sessionTitle']}} is scheduled for {{ $details['startDate'] }}, {{ $details['startTime']}}</strong>


<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
