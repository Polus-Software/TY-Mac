@component('mail::message')

<h1>Hi {{ $datas['instructorName'] }},</h1>

You have been assigned a new course {{ $datas['courseTitle'] }}.

Regards,<br>
ThinkLit Team

@endcomponent
