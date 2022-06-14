@component('mail::message')

<h1>Hello {{ $details['studentName'] }},</h1>

<strong>Your assignment for the course {{ $details['courseTitle'] }} has been reviewed by the instructor.</strong>

To view the reviewed assignment, please log in to your account on ThinkLit.com

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
