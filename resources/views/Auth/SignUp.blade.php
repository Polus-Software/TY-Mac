@extends('layouts.app')
@section('content')


<div class="container-overlay ">
    <div class="custom-container mx-auto p-3 border rounded">
        <div class="wrapper row flex-column my-5">
            <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Create an account</div>
                <form id="signupform" class="form" method="POST" action="{{ route('user.create') }}">
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
@endsection('content')