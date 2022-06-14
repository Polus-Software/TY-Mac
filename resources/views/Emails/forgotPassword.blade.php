@component('mail::message')


<h1>Forgot Password Email</h1>
   
<strong>You can reset password from the link below</strong>
@component('mail::button', ['url' => route('reset.password.get', $details['token'])])
Reset Password
@endcomponent

<p class="regards">
Regards,<br>
ThinkLit Team
</p>

@endcomponent
