@component('mail::message')

<h1>Hi {{ $details['instructorName'] }},</h1>

You have got a new concern from a student {{ $details['name'] }}

Details as follows,

{{$details['message']}}


Regards,
The ThinkLitThinklit Team

@endcomponent
