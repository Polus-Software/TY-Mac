@component('mail::message')

<h1>Dear {{ $data['studentName']}},</h1>

Thank you for your interest in {{ $data['courseTitle']}}. <br>
Live sessions for {{ $data['courseTitle']}} have been scheduled from {{ $data['startDate']}} to {{ $data['endDate']}}.
We're excited to have you join our live session.<br>

Please join the session a couple of minutes earlier to make sure everything's working properly.
If you experience any technical issues, feel free to contact me via email.

I look forward to seeing you there.

Regards,<br>
{{ $data['instructorName']}}

@endcomponent
