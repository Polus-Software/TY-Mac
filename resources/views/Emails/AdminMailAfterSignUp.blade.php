@component('mail::message')

<h1>Hello {{ $data['adminFirstName'] }} {{ $data['adminLastName'] }},</h1>

<strong>You have got a new student registration on ThinkLit</strong>.

Details:<br>

Student Name : {{ $data['firstname'] }} {{ $data['lastname'] }}<br>
Email Id : {{ $data['email'] }}<br>

To view registered students, please log in to your account on ThinkLit.com

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
