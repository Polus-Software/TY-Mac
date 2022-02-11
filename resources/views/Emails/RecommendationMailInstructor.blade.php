@component('mail::message')


<h1>Hello, {{$recDetails['instructorName']}}</h1>

We recommend you to review the following {{$recDetails['topic']}} to improve the student's understanding of the subject. 
You may also schedule 1-on-1 sessions with the student to help them with the subject.

Please log in to your account on ThinkLit.com & view the Personalized Recommendations in your account.

Regards,<br>
<p>ThinkLit team</p>


@endcomponent
