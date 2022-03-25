@component('mail::message')

<h1>Hi {{ $details['instructorName'] }},</h1>

You have got a new concern from a student {{ $details['name'] }} for the course {{ $details['courseName'] }}

Message is as follows,

<p>{{$details['message']}}</p>

Click <a href="mailto:{{ $details['email'] }}">here</a> to reply.


Regards,<br>
The ThinkLit Team

@endcomponent
