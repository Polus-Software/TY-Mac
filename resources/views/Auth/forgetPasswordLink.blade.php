
@extends('Layouts.app')
@section('content')


<div class="container-overlay">
    <div class="custom-container mx-auto p-3 border rounded">
        <div class="wrapper row flex-column my-5" >  
            <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Reset Password</div>
            
            @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
            @endif
                <form id="passwordResetForm" class="form" method="POST" action="{{ route('reset.password.post') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}"> 
                    <div class="form-group mx-sm-5 mx-0">
                        <label for="email" class="email-label">Email</label>
                        <input type="email"  name="email"class="form-control" id="email" placeholder="Eg: xyz@domainname.com">
                        <small>Error message</small>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif        
                    </div>

                    <div class="form-group mx-sm-5 mx-0">
                            <label for="inputPassword" class="password-label"> New Password</label>
                            <input type="password"  name="password" class="form-control" id="inputPassword" placeholder="Password">
                            <span><i class="fas fa-eye-slash"  id="togglePassword" onClick="viewPassword()"></i></span>
                            <small>Error message</small>
                            
                            
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                    </div>

                    <div class="form-group mx-sm-5 mx-0">
                            <label for="confirmPassword" class="password-label">Confirm Password</label>
                            <input type="password"  name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Retype password">
                            <span><i class="fas fa-eye-slash"  id="confirm_togglePassword" onClick="showPassword()"></i></span>
                            <small>Error message</small>    
                            
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif    
                    </div>

                    <div class="d-grid form-group pt-2 mx-sm-5 mx-0">
                    <button type="submit" class="btn btn-secondary btn-block"><span class="button"> Reset Password</span></button>
                    </div>
                </form>
            </div> 
        </div>      
    </div>          
</div>
<script>
    document.querySelector('#passwordResetForm').addEventListener('submit', (e) => {

        if(email.value === '') {
            e.preventDefault();
            showError(email,'Email is required');
        }else if(!isValidEmail(email.value)){
            e.preventDefault();
            showError(email,'Email is not valid');
        } else {
          removeError(email)
        }
        if(password.value === '') {
            e.preventDefault();
            showError(password,'Password is required');
        } else {
          removeError(password)
        }
        if(passwordconfirm.value === ''){
            e.preventDefault();
            showError(passwordconfirm,'Confirm password is required');
        } else {
          removeError(passwordconfirm)
        }
        
        if (password.value != passwordconfirm.value) {
            e.preventDefault();
            showError(password,'The two passwords do not match');
        } else if (password.value == passwordconfirm.value && password.value != '') {
          removeError(password)
        }
      
});

const passResetForm = document.getElementById('passwordResetForm');
const email = document.getElementById('email');
const password = document.getElementById('inputPassword');
const passwordconfirm = document.getElementById('password_confirmation');

   

function showError(input,message){
  input.style.borderColor = 'red';
  const formControl=input.parentElement;
  const small=formControl.querySelector('small');
  small.innerText=message;
  small.style.visibility = 'visible';
}

function removeError(input){
input.style.borderColor = '#ced4da';
const formControl=input.parentElement;
const small=formControl.querySelector('small');
small.style.visibility = 'hidden';
}

function isValidEmail(email)
{
    const re= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

</script>           
@endsection('content')