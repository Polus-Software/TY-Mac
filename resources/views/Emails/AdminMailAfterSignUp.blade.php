@component('mail::message')

Hello {{ $data['adminFirstName'] }} {{ $data['adminLastName'] }},

You have got a new student registration on ThinkLit.

Details:

Student Name : {{ $data['firstname'] }} {{ $data['lastname'] }}<br>
Email Id : {{ $data['email'] }}

To view registered students, please log in to your account on ThinkLit.com


Regards,
Thinklit Team

Thanks,<br>
{{ config('app.name') }}
@endcomponent
