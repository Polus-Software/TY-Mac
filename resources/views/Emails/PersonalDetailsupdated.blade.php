@component('mail::message')

<h1>Hi {{ $data['studentName']}},</h1>

You've successfully changed your {{ $data['detail']}}.

Regards,<br>
The ThinkLit Team


@endcomponent
