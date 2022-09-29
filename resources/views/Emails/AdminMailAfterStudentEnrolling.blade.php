@component('mail::message')

<h1>Hello {{ $mailData['adminFirstName'] }} {{ $mailData['adminLastName'] }},</h1>

<strong>You have got a new student enrolled in your {{ $mailData['course_title']}} course.</strong>

To view enrolled students, please log in to your account on ThinkLit.com

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
<h1>