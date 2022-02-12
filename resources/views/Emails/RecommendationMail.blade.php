@component('mail::message')


<h1>Hello, {{$recDetails['studentName']}}</h1>

We recommend you to review the following {{$recDetails['topic']}} to improve your understanding of the subject.

Please log in to your account on ThinkLit.com & view the Personalized Recommendations in your student portal.

Regards,<br>
<p>ThinkLit team</p>


@endcomponent
