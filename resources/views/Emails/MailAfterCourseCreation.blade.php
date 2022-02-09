@component('mail::message')

<h1>Hi {{ $data['adminFirstName'] }} {{ $data['adminLastName'] }},</h1>

A new course has been created by the content creator {{ $data['name'] }}.

The following course has been added <br>
{{ $data['courseTitle'] }}

Regards,<br>
ThinkLit Team

@endcomponent
