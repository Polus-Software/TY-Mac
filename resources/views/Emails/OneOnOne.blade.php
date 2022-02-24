@component('mail::message')

<h1>Hi {{ $details['name'] }},</h1>

Your 1-on-1 session with {{ $details['instructorName'] }} for the session {{ $details['session'] }} 
from the course {{ $details['course'] }} has been started. 

Please follow the link to join!

{{ $details['url'] }}

Regards,<br>
The ThinkLit Team

@endcomponent
