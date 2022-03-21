@component('mail::message')

<h1>Hi {{ $data['instructorName'] }},<h1>

You have got a new question from your student {{$data['studentName']}} on ThinkLit.

To view the message, follow this <a href="{{$data['link']}}">link</a> after logging in to your account on ThinkLit.com

Regards,<br>
The ThinkLit Team


@endcomponent
