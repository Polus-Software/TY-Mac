@component('mail::message')

<h1>Hello , {{ $details['instructorName']}}</h1>

<p>You have got a new message from your student {{ $details['studentName'] }}.</p>

<p>To view the message, please log in to your account on ThinkLit.com</p>


Regards,<br>
Thinklit Team

@endcomponent





