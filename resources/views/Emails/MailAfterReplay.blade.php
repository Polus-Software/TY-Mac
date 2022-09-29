@component('mail::message')

<h1>Hello {{$details['studentName']}}</h1>

<strong>You have got a reply to your message from your Instructor {{$details['instructorName']}} 
for the course {{$details['courseTitle']}}</strong>  on ThinkLit.

To view the message, please log in to your account on ThinkLit.com

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
