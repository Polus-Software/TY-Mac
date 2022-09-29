@component('mail::message')

<h1>Hi {{ $datas['instructorName'] }},</h1>

<strong>You have been assigned a new course {{ $datas['courseTitle'] }}</strong>.

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
