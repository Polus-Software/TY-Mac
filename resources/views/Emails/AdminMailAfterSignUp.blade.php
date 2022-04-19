@component('mail::message')

Hello {{ $data['adminFirstName'] }} {{ $data['adminLastName'] }},

You have got a new student registration on ThinkLit.

Details:<br>

Student Name : {{ $data['firstname'] }} {{ $data['lastname'] }}<br>
Email Id : {{ $data['email'] }}<br>

To view registered students, please log in to your account on ThinkLit.com


Regards,<br>
ThinkLit Team

@endcomponent
