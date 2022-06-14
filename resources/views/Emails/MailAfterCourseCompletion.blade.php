@component('mail::message')

<h1>Hello {{ $mailData['studentName']}},</h1>

<strong>Thank you for completing the course {{ $mailData['courseTitle']}}</strong>. 
Please feel free to <strong>share your feedback by reviewing the course</strong>.

@component('mail::button', ['url' => 'base_path() . "/enrolled-course/" . $courseId . "?feedback=true"'])
Add Course Rating
@endcomponent

<p class="regards">
Regards,<br>
ThinkLit Team
</p>


@endcomponent
