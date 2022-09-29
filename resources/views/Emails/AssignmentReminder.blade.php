@component('mail::message')


<h1>Dear {{$data['firstname']}} {{$data['lastname']}}</h1>

<strong>The deadline for completing the assignment for the course {{$data['course_name']}} is {{$data['date']}}</strong>. That's one day from now. Please make sure you've finished the assignment by then.

To access the assignment go to <a href="{{$data['link']}}">{{$data['link']}}</d>

If you have any questions regarding the assignment, please reach out via the Cohort Q&A section in your student portal on thinklit.com


<p class="regards">
Regards,<br>
{{ $data['instructor_name']}}
</p>

@endcomponent


