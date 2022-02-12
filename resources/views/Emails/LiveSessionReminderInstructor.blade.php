@component('mail::message')


<h1>Hello, {{$iDetails['instructorName']}}</h1>

This is a reminder that you are scheduled to teach {{$iDetails['sessionName']}} in {{$iDetails['reminder']}}.

Regards,
<p>ThinkLit team</p>


@endcomponent
