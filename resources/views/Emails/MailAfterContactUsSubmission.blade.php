@component('mail::message')

<h1>Hi {{$details['adminFirstName']}} {{$details['adminLastName']}},</h1>

<strong>You have got a new query from the student {{$details['name']}}</strong><br>

Details as follows,<br>

{{$details['message']}}<br>

<a href="mailto:{{ $details['email'] }}"><b>Click<b> here to reply</a>


<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
