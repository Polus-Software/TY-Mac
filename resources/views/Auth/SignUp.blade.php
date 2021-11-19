@extends('Layouts.app')
@section('content')

<style>
    #search-btn {
        background-color:#fff !important;
        color: #000 !important;
        border: 1px solid #000 !important;
    }

    .navbar-nav li {
        margin : 0px 5px !important;
    }

    .me-auto {
        margin-left: auto !important;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 d-flex me-auto">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width:30rem !important;">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
      </form>

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">All Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Apply to be an instructor?</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('signup') }}">Signup</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> -->
      </ul>
      
    </div>
  </div>
</nav>
<div class="container-overlay ">
    <div class="custom-container mx-auto p-3 border rounded">
        <div class="wrapper row flex-column my-5">
            <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Create an account</div>
                <form id="signupForm" class="form" method="POST" action="{{ route('user.create') }}">
                    @csrf
                    <input type="hidden" name ="_method" value ="POST">
                                
                    <div class="form-group mx-sm-5 mx-0">
                        <label for="firstName" class="firstname-label">First Name</label>
                        <input type="text" name="firstname" class="form-control" id="firstName" placeholder="Eg: Denis"
                        value="{{old('firstname')}}">
                        <small>Error message</small>

                        @if ($errors->has('firstname'))
                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                        @endif
                        </span>
                    </div>         

                    <div class="form-group mx-sm-5 mx-0">
                            <label for="lastName" class="lastname-label">Last Name</label>
                            <input type="text"  name="lastname" class="form-control" id="lastName" placeholder="Eg: Cheryshev"
                            value="{{old('lastname')}}">
                            <small>Error message</small>

                            @if ($errors->has('lastname'))
                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                            @endif
                            
                    </div>
                                
                    <div class="form-group mx-sm-5 mx-0">
                            <label for="email" class="email-label">Email</label>
                            <input type="email"  name="email" class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com"
                            value="{{old('email')}}">
                            <small>Error message</small>

                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                    </div>
                            
                    <div class="form-group mx-sm-5 mx-0">
                            <label for="inputPassword" class="password-label">Password</label>
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

                    <div class="form-group mx-sm-5 mx-0">
                            <label class="form-check-label checkbox-text">
                            <input  class="form-check-input" name="privacy_policy" type="checkbox" > By creationg an account , you agree to the 
                            <a href="#">Terms of Service</a><br> &nbsp; and Conditions, and Privacy Policy</label>
                            @if ($errors->has('privacy_policy'))
                                <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                            @endif   
                    </div>

                    <div class="d-grid form-group mx-sm-5 mx-0">
                    <button type="submit" class="btn btn-block"><span class="button">Create</span></button>
                    </div>

                    <div class="text-center bottom-text">
                        <span><p>Already have an account? </span>
                        <span class="login"><a href="{{ route('login') }}">&nbsp;Login</a></p></span>
                    </div>
                </form>  
            </div>              
        </div>            
    </div>        
</div>    

<script>
    document.querySelector('#signupForm').addEventListener('submit', (e) => {
        if(firstname.value === '') {
            e.preventDefault();
            showError(firstname,'First name is required');
        } else {
          removeError(firstname)
        }
        if(lastname.value === '') {
            e.preventDefault();
            showError(lastname,'Last name is required');
        } else {
          removeError(lastname)
        }
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

  const form = document.getElementById('signupForm');
  const firstname = document.getElementById('firstName');
  const lastname = document.getElementById('lastName');
  const email = document.getElementById('inputEmail');
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