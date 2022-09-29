@component('mail::message')


<h1>Hello, {{$recDetails['instructorName']}}</h1>

<strong>We recommend you to review the following {{$recDetails['topic']}} to improve the student's understanding of the subject</strong>. 
You may also schedule 1-on-1 sessions with the student to help them with the subject.

Please log in to your account on ThinkLit.com & view the Personalized Recommendations in your account.

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
