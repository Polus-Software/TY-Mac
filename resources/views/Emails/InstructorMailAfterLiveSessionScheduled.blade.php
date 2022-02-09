@component('mail::message')

<h1>Hi {{ $details['instructorName']}},</h1>

Your live session  {{ $details['sessionTitle']}} is scheduled for {{ $details['startDate']}}, {{ $details['startTime']}}


Regards,<br>
The ThinkLit Team

@endcomponent
