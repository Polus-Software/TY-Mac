@component('mail::message')

<h1>Hello {{ $details['studentName'] }},</h1>

Your assignment for the course {{ $details['courseTitle'] }} has been reviewed by the instructor.

To view the reviewed assignment, please log in to your account on ThinkLit.com

Regards,<br>
The ThinkLit Team

@endcomponent
