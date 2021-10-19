@extends('app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="signupform border border-1 rounded" >  
                    <div class="heading ">
                        <h3 class="text-start">Create an account</h3>
                    </div>  
                        <div>
                            <form method="" action="">
                                @csrf
                                <div class="form-group">
                                    <label for="firstName" class="firstname-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Eg: Denis">
                                </div>
                                <div class="form-group">
                                    <label for="lastName" class="lastname-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Eg: Cheryshev">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="email-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="password-label">Password</label>
                                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                                    
                                </div>
                                <div class="form-group">
                                    <label class="form-check-label checkbox-text">
                                    <input  class="form-check-input" type="checkbox"> By creationg an account , you agree to the 
                                    <a href="#">Terms of Service</a><br> &nbsp; and Conditions, and Privacy Policy</label>
                                </div>
                                <div class="d-grid form-group">
                                <button type="submit" class="btn btn-block"><span class="button">Create</span></button>
                                </div>

                                <div class="text-center bottom-text">
                                    <span><p>Already have an account? </span>
                                    <span class="login"><a href="#">&nbsp;Login</a></p></span>
                                </div>
                            </form>            
                    </div>  

</div>
    
</div>  
</div>
<div>        
            





@endsection('content')