@component('mail::message')

<h1>Hello, {{$mailDetails['firstname']}} {{$mailDetails['lastname']}}</h1>
<p><strong>Welcome to the {{ $mailDetails['course'] }} course!</strong></p>

To access your course content & course schedule, please login into ThinkLit.com.

If you have any questions regarding the course, please reach out via the Cohort Q&A section in your student portal.


<p class="regards">
Regards,<br>
{{ $mailDetails['instructor_name']}}
</p>

@endcomponent
