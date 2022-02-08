@component('mail::message')

<h1>Hi {{$details['instructorName']}},</h1>

You have new feedback from your student {{$details['studentName']}} on your course {{$details['courseTitle']}}.

Regards,<br>
The ThinkLit Team


@endcomponent
