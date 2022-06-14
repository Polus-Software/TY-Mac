@component('mail::message')

<h1>Hello , {{ $data['instructor_name']}}</h1>

<p><strong>You have got a new student enrolled in your assigned course {{ $data['course_title'] }}.</strong></p>

<p>To view enrolled students, please log in to your account on ThinkLit.com</p>

<p class="regards">
Regards,<br>
ThinkLit Team
</p>


@endcomponent





