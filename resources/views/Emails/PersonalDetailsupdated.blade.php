@component('mail::message')

<h1>Hi {{ $data['firstname']}} {{ $data['lastname']}},</h1>

You've successfully changed your Password.

Regards,
The ThinkLit Team




Thanks,<br>
{{ config('app.name') }}
@endcomponent
