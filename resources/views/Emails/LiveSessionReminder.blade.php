@component('mail::message')


<h1>Hello, {{$details['firstname']}} {{$details['lastname']}}</h1>

<strong>{{$details['session_name']}} for {{$details['course_name']}} starts on {{$details['time']}}.</strong>

The session starts {{$details['reminder']}} from now!

We look forward to having you attend.


Regards,
<p>{{ $details['instructor_name']}}</p>

<p class="regards">
Regards,<br>
{{ $details['instructor_name']}}
</p>

@endcomponent
