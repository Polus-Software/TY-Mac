@component('mail::message')

<h1>Hi {{ $details['name'] }},</h1>

<strong>Your 1-on-1 session with {{ $details['instructorName'] }} for the session {{ $details['session'] }} 
from the course {{ $details['course'] }} has been started</strong>. 

Please follow the link to join!

{{ $details['url'] }}

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
