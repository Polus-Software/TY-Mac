@component('mail::message')

<h1>Hi {{ $data['adminFirstName'] }} {{ $data['adminLastName'] }},</h1>

<strong>A new course has been created by the content creator {{ $data['name'] }}</strong>.

The following course has been added <br>
{{ $data['courseTitle'] }}

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
