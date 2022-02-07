@component('mail::message')

<h1>Hi {{$details['adminFirstName']}} {{$details['adminLastName']}},</h1>

You have got a new query from the student {{$details['name']}}

Details as follows,

{{$details['message']}}

Regards,<br>
The ThinkLit Team

@endcomponent
