@component('mail::message')

<h1>Hi {{ $data['instructorName'] }},<h1>

<strong>You have got a new question from your student {{$data['studentName']}} on ThinkLit</strong>.

To view the message, follow this <a href="{{$data['link']}}">link</a> after logging in to your account on ThinkLit.com

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
