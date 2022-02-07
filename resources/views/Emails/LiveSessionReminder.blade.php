@component('mail::message')


<h1>Hello, {{$details['firstname']}} {{$details['lastname']}}</h1>

{{$details['session_name']}} for {{$details['course_name']}} starts in {{$details['time']}}!

We look forward to having you attend.

{{$details['link']}}

Regards,
<p>{{ $details['instructor_name']}}</p>


@endcomponent
