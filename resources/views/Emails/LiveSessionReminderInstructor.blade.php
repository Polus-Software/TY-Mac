@component('mail::message')


<h1>Hello, {{$details['instructorName']}}</h1>

<strong>This is a reminder that you are scheduled to teach {{$details['sessionName']}} in {{$details['reminder']}}.</strong>

<p class="regards">
Regards,<br>
ThinkLit Team
</p>


@endcomponent
