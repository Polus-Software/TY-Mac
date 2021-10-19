@extends('app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="loginform border border-1 rounded" >  
                    <div class="heading ">
                        <h3 class="text-start">Log in to account</h3>
                    </div>  
                        <div>
                            <form method="" action="">
                                @csrf
                                
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
                                    <input  class="form-check-input" type="checkbox"> &nbsp;Remember me</label>
                                </div>
                                <div class="d-grid form-group">
                                <button type="submit" class="btn btn-block"><span class="button">login</span></button>
                                </div>

                                <div class="text-center forgotpass">
                                    <span><p><a href="">Forgot password? </a></span>
                                    
                                </div>

                                <div class="text-center bottomsignup-text">
                                    <span><p>Don't have an account? </span>
                                    <span class="login"><a href="#">&nbsp;Sign up</a></p></span>
                                </div>
                            </form>            
                    </div>  

</div>
    
</div>  
</div>
<div>        
            





@endsection('content')