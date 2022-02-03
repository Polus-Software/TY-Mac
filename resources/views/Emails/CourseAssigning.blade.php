@component('mail::message')

<h1>Hi {{ $datas['instructorName'] }},</h1>


You have been assigned to a new course {{ $datas['courseTitle'] }} .

Regards,
ThinkLitThinklit Team


Thanks,<br>
{{ config('app.name') }}
@endcomponent
