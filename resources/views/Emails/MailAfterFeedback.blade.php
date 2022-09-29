@component('mail::message')

<h1>Hi {{$details['instructorName']}},</h1>

<strong>You have new feedback from your student {{$details['studentName']}} on your course {{$details['courseTitle']}}</strong>.

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
