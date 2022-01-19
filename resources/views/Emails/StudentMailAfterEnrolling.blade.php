@component('mail::message')


<h1>Hello, {{$mailDetails['firstname']}} {{$mailDetails['lastname']}}</h1>
Welcome to the [Course Name] scheduled for [Date & Time].

To access your course content & course schedule, please login into ThinkLit.com.

If you have any questions regarding the course, please reach out via the Cohort Q&A section in your student portal.

Regards,
<p>{{ $mailDetails['instructor_name']}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
