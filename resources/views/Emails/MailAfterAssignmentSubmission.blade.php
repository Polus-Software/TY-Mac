@component('mail::message')

Hi {{$data['instructorName']}},

You have got a new assignment submitted by {{$data['studentName']}} for the course {{$data['courseTitle']}}.

To view the submitted assignment, please log in to your account on ThinkLit.com

Regards,<br>
ThinkLit Team

@endcomponent
