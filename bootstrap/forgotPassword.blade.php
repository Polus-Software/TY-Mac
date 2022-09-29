@component('mail::message')


<h1>Forgot Password Email</h1>
   
You can reset password from the link below

@component('mail::button', ['url' => route('reset.password.get', $details['token'])])
Reset Password
@endcomponent

Regarding,<br>
ThinkLit Team

@endcomponent
