@component('mail::message')

<h1>Hello {{ $mailData['studentName']}},</h1>


Thank you for completing the course {{ $mailData['courseTitle']}}. 
Please feel free to share your feedback by reviewing the course.

@component('mail::button', ['url' => 'base_path() . "/enrolled-course/" . $courseId . "?feedback=true"'])
Add Course Rating
@endcomponent

Regards,<br>
ThinkLit Team


@endcomponent
