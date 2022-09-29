@extends('Layouts.app')
@section('content')
<body class="bg-secondary">
    <div class="container-overlay pt-5">
        <div class="custom-container mx-auto p-3 border rounded">
            <div class="wrapper row flex-column my-5" >  
                <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Reset Password</div>
                
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    
                    <form id="passwordResetLink" class="form" method="POST" action="{{ route('forget.password.post') }}">
                        @csrf
                                    
                        <div class="form-group mx-sm-5 mx-0">
                            <label for="email" class="email-label">Email</label>
                            <input type="email"  name="email"class="form-control" id="email" placeholder="Eg: xyz@domainname.com">
                            <small>Error message</small>
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif        
                        </div>
                        <div class="d-grid form-group pt-2 mx-sm-5 mx-0">
                        <button type="submit" class="btn btn-secondary btn-block text-white"><span class="button">Send Password Reset Link</span></button>
                        </div>
                    </form>
                </div> 
            </div>      
        </div>          
    </div>
</body>

<script>
    document.querySelector('#passwordResetLink').addEventListener('submit', (e) => {
        if(email.value === '') {
            e.preventDefault();
            showError(email,'Email is required');
        }else if(!isValidEmail(email.value)){
            e.preventDefault();
            showError(email,'Email is not valid');
        } else {
          removeError(email)
        }
      
});

const passResetLink = document.getElementById('passwordResetLink');
const email = document.getElementById('email');

   

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