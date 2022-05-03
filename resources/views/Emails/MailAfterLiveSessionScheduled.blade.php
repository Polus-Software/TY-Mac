@component('mail::message')

<h1>Dear {{ $data['studentName']}},</h1>

Thank you for your interest in {{ $data['courseTitle']}}. <br>
Live session - {{ $data['sessionTitle'] }} from {{ $data['courseTitle']}} has been scheduled on {{ date('m/d/Y', strtotime($data['startDate'])) }}.
We're excited to have you join our live session.<br>

Please join the session a couple of minutes earlier to make sure everything's working properly.
If you experience any technical issues, feel free to contact me via email.

I look forward to seeing you there.

Regards,<br>
{{ $data['instructorName']}}

@endcomponent
