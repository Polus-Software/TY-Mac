@component('mail::message')

Hi {{$details['instructorName']}},

You have got a new assignment submitted by {{$details['studentName']}} for the course {{$details['courseTitle']}}.

To view the submitted assignment, please log in to your account on ThinkLit.com

Regards,
ThinkLit Team

@endcomponent
