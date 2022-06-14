@component('mail::message')

<h1>Dear {{ $data['studentName']}},</h1>

<strong>Thank you for your interest in {{ $data['courseTitle']}}.</strong><br>
<strong>Live session - {{ $data['sessionTitle'] }} from {{ $data['courseTitle']}} has been scheduled on {{ date('m/d/Y', strtotime($data['startDate'])) }}</strong>.
We're excited to have you join our live session.<br>

Please join the session a couple of minutes earlier to make sure everything's working properly.
If you experience any technical issues, feel free to contact me via email.

I look forward to seeing you there.

<p class="regards">
Regards,<br>
{{ $data['instructorName']}}
</p>

@endcomponent
