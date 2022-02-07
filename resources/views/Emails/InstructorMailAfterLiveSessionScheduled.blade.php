@component('mail::message')

<h1>Hi {{ $details['instructorName']}},</h1>

Your live session  {{ $details['sessionTitle']}} is scheduled for {{ $details['startDate']}} {{ $details['startTime']}}

To log in, click on this link [joining link]

Regards,
The ThinkLit Team

@endcomponent
