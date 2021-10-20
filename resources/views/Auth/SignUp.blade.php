@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="col-md-4 col-sm-8 m-auto">
                     <div class="signupform border border-1 rounded" >  
                            <div class="heading ">
                                <h3 class="text-start">Create an account</h3>
                            </div>  
                            <div>
                            <form method="POST" action="{{ route('user.create') }}">
                                @csrf
                                <input type="hidden" name ="_method" value ="POST">

                                <div class="form-group">
                                    <label for="firstName" class="firstname-label">First Name</label>
                                    <input type="text"  name="firstname"class="form-control" id="firstName" placeholder="Eg: Denis"
                                    value="{{old('firstname')}}">
                                    @if ($errors->has('firstname'))
                                    <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                    @endif
                                    </span>
                                    
                                </div>
                                
                                    


                                <div class="form-group">
                                    <label for="lastName" class="lastname-label">Last Name</label>
                                    <input type="text"  name="lastname" class="form-control" id="lastName" placeholder="Eg: Cheryshev"
                                    value="{{old('lastname')}}">

                                    @if ($errors->has('lastname'))
                                    <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                    @endif
                                    
                                </div>
                                    
                                    
                                   
                                <div class="form-group">
                                    <label for="email" class="email-label">Email</label>
                                    <input type="email"  name="email" class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com"
                                    value="{{old('email')}}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                   
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputPassword" class="password-label">Password</label>
                                    <input type="password"  name="password" class="form-control" id="inputPassword" placeholder="Password"  value="{{old('password')}}">
                                    <span><i class="fas fa-eye-slash"  id="togglePassword" onClick="viewPassword()"></i></span>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                   
                                </div>

                                <div class="form-group">
                                    <label class="form-check-label checkbox-text">
                                    <input  class="form-check-input" name="privacy_policy" type="checkbox" > By creationg an account , you agree to the 
                                    <a href="#">Terms of Service</a><br> &nbsp; and Conditions, and Privacy Policy</label>
                                </div>

                                <div class="d-grid form-group">
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
        </div>

    </div>  
    
  

     
            





@endsection('content')