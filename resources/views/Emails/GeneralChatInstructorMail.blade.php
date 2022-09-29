@component('mail::message')

<h1>Hello , {{ $details['instructorName']}}</h1>

<p><strong>You have got a new message from your student {{ $details['studentName'] }}.</strong></p>

<p>To view the message, please log in to your account on ThinkLit.com</p>


<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent





