@component('mail::message')

<h1>Hello {{$details['studentName']}}</h1>

You have got a reply to your message from your Instructor {{$details['instructorName']}} 
for the course {{$details['courseTitle']}}  on Thinklit.

To view the message, please log in to your account on ThinkLit.com

Regards,
The ThinkLit Team


@endcomponent
