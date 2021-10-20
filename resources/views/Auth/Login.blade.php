@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="loginform border border-1 rounded" >  
                    <div class="heading ">
                        <h3 class="text-start">Log in to account</h3>
                    </div>  
                        <div>
                            <form method="POST" action="{{route('user.loginin')}}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="email" class="email-label">Email</label>
                                    <input type="email"  name="email"class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com"
                                    value="{{old('email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="password-label">Password</label>
                                    <input type="password"  name="password" class="form-control" id="inputPassword" placeholder="Password"  value="{{old('password')}}">
                                    <span><i class="fas fa-eye-slash"  id="togglePassword" onClick="viewPassword()"></i></span>

                                  
                                </div>
                                <div class="form-group">
                                    <label class="form-check-label checkbox-text">
                                    <input  class="form-check-input" type="checkbox"> &nbsp;Remember me</label>
                                </div>
                                <div class="d-grid form-group">
                                <button type="submit" class="btn btn-block"><span class="button">login</span></button>
                                </div>

                                <div class="text-center forgotpass">
                                    <span class="forgotpwd"><a href="">Forgot password? </a></span>
                                    
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
<div>        
            





@endsection('content')