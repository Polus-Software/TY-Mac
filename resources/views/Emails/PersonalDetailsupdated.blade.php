@component('mail::message')

<h1>Hi {{ $data['studentName']}},</h1>

<strong>You've successfully changed your {{ $data['detail']}}</strong>.

<p class="regards">
Regards,<br>
ThinkLit Team
</p>


@endcomponent
