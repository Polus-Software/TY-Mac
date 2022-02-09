@component('mail::message')


<h1>Dear {{$details['firstname']}} {{$details['lastname']}}</h1>

The deadline for completing the assignment for the course {{$details['course_name']}} is {{$details['date']}}. That’s one day from now. Please make sure you’ve finished the assignment by then.

To access the assignment go to <a href="{{$details['link']}}">{{$details['link']}}</d>

If you have any questions regarding the assignment, please reach out via the Cohort Q&A section in your student portal on thinklit.com

Regards,
<p>{{ $details['instructor_name']}}</p>


@endcomponent


