@component('mail::message')


Hello {{ $mailData['adminFirstName'] }} {{ $mailData['adminLastname'] }},

You have got a new student enrolled in your {{ $mailData['course_title']}} course.

To view enrolled students, please log in to your account on ThinkLit.com

Regards,<br>
Thinklit Team

@endcomponent
