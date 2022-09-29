@component('mail::message')

<h1>Hi {{$data['instructorName']}},</h1>

<strong>You have got a new assignment submission by {{$data['studentName']}} for the course {{$data['courseTitle']}}.</strong>

To view the submitted assignment, please log in to your account on ThinkLit.com

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
