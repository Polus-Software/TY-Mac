@component('mail::message')

<h1>Hello , {{ $details['studentName']}}</h1>

<p>You have got a new message from your instructor {{ $details['instructorName'] }}.</p>

<p>To view the message, please log in to your account on ThinkLit.com</p>


Regards,<br>
ThinkLit Team

@endcomponent





