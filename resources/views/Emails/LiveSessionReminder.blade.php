@component('mail::message')


<h1>Hello, {{$details['firstname']}} {{$details['lastname']}}</h1>

{{$details['session_name']}} for {{$details['course_name']}} starts on {{$details['time']}}.

The session starts {{$details['reminder']}} from now!

We look forward to having you attend.


Regards,
<p>{{ $details['instructor_name']}}</p>


@endcomponent
