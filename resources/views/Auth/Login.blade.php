@extends('Layouts.app')
@section('content')

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
<div class="container-overlay">
    <div class="custom-container mx-auto p-3 border rounded">
        <div class="wrapper row flex-column my-5" >  
            <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Log in to account</div>
                <form id="loginForm" class="form" method="POST" action="{{route('user.login')}}">
                    @csrf
                                
                    <div class="form-group mx-sm-5 mx-0">
                        <label for="email" class="email-label">Email</label>
                        <input type="email"  name="email"class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com"
                        value="{{old('email')}}">
                        <small>Error message</small>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif        
                    </div>
                    <div class="form-group mx-sm-5 mx-0">
                        <label for="inputPassword" class="password-label">Password</label>
                        <input type="password"  name="password" class="form-control" id="inputPassword" placeholder="Password"  value="{{old('password')}}">
                        <span><i class="fas fa-eye-slash"  id="togglePassword" onClick="viewPassword()"></i></span>
                        <small>Error message</small>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group mx-sm-5 mx-0">
                        <label class="form-check-label rememberme">
                        <input  class="form-check-input"  name="remember_me" type="checkbox"> &nbsp;Remember me</label>
                    </div>

                    <div class="d-grid form-group  mx-sm-5 mx-0">
                    <button type="submit" class="btn btn-block"><span class="button">Login</span></button>
                    </div>

                    <div class="text-center forgotpass">
                        <span class="forgotpwd"><a href="{{ route('forget.password.get')}}"> Forgot password? </a></span>
                        
                    </div>

                    <div class="text-center bottom-text">
                        <span><p>Don't have an account? </span>
                        <span class="login"><a href="{{ route('signup') }}">&nbsp;Sign up</a></p></span>
                    </div>            
            
                </form>
            </div> 
        </div>      
    </div>          
</div>
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
<script>
    document.querySelector('#loginForm').addEventListener('submit', (e) => {
      if(loginemail.value === '') {
        e.preventDefault();
        showError(loginemail,'Email is required');
      }else {
        removeError(loginemail)
      }
      if(loginpassword.value === '') {
        e.preventDefault();
        showError(loginpassword,'Password is required');
      } else {
        removeError(loginpassword)
      }
});

const loginform = document.getElementById('loginForm');
const loginemail = document.getElementById('inputEmail');
const loginpassword = document.getElementById('inputPassword');
   

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

</script>           
@endsection('content')