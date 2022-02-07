@component('mail::message')

<h1>Hello , {{ $data['instructor_name']}}</h1>

<p>You have got a new student enrolled in your assigned course {{ $data['course_title'] }}.</p>

<p>To view enrolled students, please log in to your account on ThinkLit.com</p>


Regards,<br>
Thinklit Team

@endcomponent





