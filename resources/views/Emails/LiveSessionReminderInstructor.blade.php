@component('mail::message')


<h1>Hello, {{$details['instructorName']}}</h1>

This is a reminder that you are scheduled to teach {{$details['sessionName']}} in {{$details['reminder']}}.

Regards,
<p>ThinkLit team</p>


@endcomponent
