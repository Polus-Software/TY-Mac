@component('mail::message')

<h1>Hi {{$details['adminFirstName']}} {{$details['adminLastName']}},</h1>

You have got a new query from the student {{$details['name']}}<br>

Details as follows,<br>

{{$details['message']}}<br>

<a href="mailto:{{ $details['email'] }}"><b>Click<b> here to reply</a>


Regards,<br>
The ThinkLit Team

@endcomponent
