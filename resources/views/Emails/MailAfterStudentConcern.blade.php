@component('mail::message')

<h1>Hi {{ $details['instructorName'] }},</h1>

<strong>You have got a new concern from a student {{ $details['name'] }} for the course {{ $details['courseName'] }}</strong>

Message is as follows,

<p>{{$details['message']}}</p>

Click <a href="mailto:{{ $details['email'] }}">here</a> to reply.


<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
