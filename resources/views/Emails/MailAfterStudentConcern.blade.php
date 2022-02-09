@component('mail::message')

<h1>Hi {{ $details['instructorName'] }},</h1>

You have got a new concern from a student {{ $details['name'] }}

Details as follows,

<p>{{$details['message']}}</p>


Regards,<br>
The ThinkLit Team

@endcomponent
