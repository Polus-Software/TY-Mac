@component('mail::message')


<h1>Forget Password Email</h1>
   
You can reset password from bellow link:

@component('mail::button', ['url' => route('reset.password.get', $details['token'])])
Reset Password
@endcomponent

Regards,<br>
Thinklit Team

@endcomponent
