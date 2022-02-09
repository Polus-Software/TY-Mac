@component('mail::message')

<h1>Hi {{ $data['userName']}},</h1>

You've successfully changed your {{ $data['detail']}}.

Regards,<br>
The ThinkLit Team


@endcomponent
