@component('mail::message')

<h1>Hello , {{ $details['studentName']}}</h1>

<p><strong>You have got a new message from your instructor {{ $details['instructorName'] }}.</strong></p>

<p>To view the message, please log in to your account on ThinkLit.com</p>


<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent





