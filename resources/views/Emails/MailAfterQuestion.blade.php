@component('mail::message')

<h1>Hi {{$data['instructorName']}}<h1>,

You have got a new message from your student {{$data['studentName']}} on ThinkLit.

To view the message, please log in to your account on ThinkLit.com

Regards,
The ThinkLit Team


@endcomponent
