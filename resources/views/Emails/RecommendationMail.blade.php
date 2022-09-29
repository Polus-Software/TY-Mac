@component('mail::message')


<h1>Hello, {{$recDetails['studentName']}}</h1>

<strong>We recommend you to review the following {{$recDetails['topic']}} to improve your understanding of the subject.</strong>

Please log in to your account on ThinkLit.com & view the Personalized Recommendations in your student portal.

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
