@extends('Layouts.myCourses')
@section('content')
<style>
  .btn-outline-success {
    border-color: #000000 !important;
}
.btn-outline-success:hover {
  background-color: #fff !important;
  border-color: #000000 !important;
  color: #000000 !important;
}
.card-2:hover {
    cursor: pointer;
}
  </style>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 d-flex me-auto mt-2 col-lg-6">
      @csrf
        <input id="search-box" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style=";">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
      </form>

      <ul class="navbar-nav me-2">
      @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="{{ route('edituser') }}">Welcome, {{Auth::user()->firstname}}</a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('student.courses.get') }}">All Courses</a>
        </li>
        
        @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('assigned-courses') }}">Assigne Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item">
        <a class="nav-link" href="#signup" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
        </li>
        @endif
      </ul>
      
    </div>
  </div>
</nav>
<!-- login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-overlay">
                    <div class="mx-auto">
                        <div class="wrapper row flex-column my-5" >  
                            <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Log in to account</div>
                                <form id="loginForm" class="form" method="POST" action="{{route('user.login.post')}}">
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
                                        <button type="submit" class="btn btn-block loginBtn"><span class="button">Login</span></button>
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
            </div>
        </div>
    </div>
</div>
<!-- login modal ends -->
 <!-- signup modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-container mx-auto p-3 rounded">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title mx-sm-5 mx-0 custom-form-header" id="signupModalLabel">Create an account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-overlay">
                    <form id="signupForm" class="form" method="POST" action="{{ route('user.create') }}">
                       @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-group mx-sm-5 mx-0">
                            <label for="firstName" class="firstname-label">First Name</label>
                            <input type="text" name="firstname" class="form-control" id="firstName" placeholder="Eg: Denis" value="{{old('firstname')}}">
                            <small>Error message</small>

                            @if ($errors->has('firstname'))
                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                            @endif
                            </span>
                        </div>

                        <div class="form-group mx-sm-5 mx-0">
                            <label for="lastName" class="lastname-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" id="lastName" placeholder="Eg: Cheryshev" value="{{old('lastname')}}">
                            <small>Error message</small>

                            @if ($errors->has('lastname'))
                            <span class="text-danger">{{ $errors->first('lastname') }}</span>
                            @endif

                        </div>

                        <div class="form-group mx-sm-5 mx-0">
                            <label for="email" class="email-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Eg: xyz@domainname.com" value="{{old('email')}}">
                            <small>Error message</small>

                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group mx-sm-5 mx-0">
                            <label for="inputPassword" class="password-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            <span><i class="fas fa-eye-slash" id="togglePass" onClick="viewPassword()"></i></span>
                            <small>Error message</small>


                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group mx-sm-5 mx-0">
                            <label for="confirmPassword" class="password-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Retype password">
                            <span><i class="fas fa-eye-slash" id="confirm_togglePassword" onClick="showPassword()"></i></span>
                            <small>Error message</small>

                            @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>

                        <div class="form-group mx-sm-5 mx-0">
                            <label class="form-check-label checkbox-text">
                            <input class="form-check-input" name="privacy_policy" type="checkbox"> By creationg an account , you agree to the
                            <a href="#">Terms of Service</a> and Conditions, and Privacy Policy</label>
                            @if ($errors->has('privacy_policy'))
                            <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                            @endif
                        </div>

                        <div class="d-grid form-group mx-sm-5 mx-0">
                            <button type="submit" class="btn btn-secondary loginBtn"><span class="button">Create</span></button>
                        </div>

                        <div class="text-center bottom-text">
                            <span>
                            <p>Already have an account?
                            </span>
                            <span class="login"><a href="{{ route('login') }}">&nbsp;Login</a></p></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer border-0"></div>
        </div>
    </div>
</div>
<!-- signup modal ends -->
    <section class="pt-5">
        <div class="container">
            <div class="row border-bottom mt-5 pb-3">
                <div class="col-lg-6 col-md-6 col-sm-7 col-12">
                    <h3>Current Live Classes</h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-5 col-12 d-flex  justify-content-lg-end justify-content-md-end justify-content-sm-end">
                    <ul class="nav nav-tabs border border-dark">
                        <li class="nav-item active">
                            <button class="nav-link active" id="live-tab" type="button" data-bs-toggle="tab"
                                data-bs-target="#live" role="tab" aria-controls="live" aria-selected="true"
                                data-bs-toggle="tab">Live</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="upcoming-tab" type="button" data-bs-toggle="tab"
                                data-bs-target="#upcoming" role="tab" aria-controls="upcoming" aria-selected="false"
                                data-bs-toggle="tab">Upcoming</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>




    <section class="mt-4">
        <div class="container">
            <div class="row">
                <div class="tab-content">
                    <div id="live" class="tab-pane fade show active" aria-labelledby="live-tab">
                        <div class="col-lg-12">
                            <div id="liveCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            
                                            @foreach($liveSessionDetails as $liveSessionDetail)
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">{{ $liveSessionDetail['session_title'] }}</h5>
                                                        <p class="card-text text-sm-start">{{ $liveSessionDetail['course_desc'] }}</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i> {{ $liveSessionDetail['instructor'] }}</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> {{ $liveSessionDetail['course_diff'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Join now</a>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                    <!-- first slide ends -->

                                    <!-- <div class="carousel-item">
                                        <div class="row">
                                            
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                            Google Drive 4</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Join now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                            Google Drive 5</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Join now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">Fundamentals of Google Docs &
                                                            Google Drive 6</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Join now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#liveCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#liveCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                    <div id="upcoming" class="tab-pane fade" aria-labelledby="upcoming-tab">
                        <div class="col-lg-12">
                            <div id="upcomingCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            @foreach($upComingSessionDetails as $upComingSessionDetail)
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">{{ $upComingSessionDetail['session_title'] }}</h5>
                                                        <p class="card-text text-sm-start">{{ $upComingSessionDetail['course_desc'] }}</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>{{ $upComingSessionDetail['instructor'] }}</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> {{ $upComingSessionDetail['course_diff'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                            <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">upcoming 2</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">upcoming 3</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>

                                    <!-- first slide ends -->

                                    <!-- <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">upcoming 4</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">upcoming 5</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">upcoming 6</h5>
                                                        <p class="card-text text-sm-start">By learning both of these apps,
                                                            you will gain valuable productivity skills &
                                                            become more efficient at creating documents, spreadsheets, and
                                                            presentations.</p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>instructor</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> beginner</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#upcomingCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#upcomingCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <div class="container">
            <div class="row border-bottom pb-3">
                <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-start">
                    <h3>My Courses</h3>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-end">
                    <select name="" id="" class="rounded pe-4">
                        <option value="most-popular">Course in progress</option>
                    </select>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-lg-12">
                    @foreach ($singleEnrolledCourseData as $singleEnrolledCourse)
                        <div class="card-2 mb-3 mt-4" data-id="{{ $singleEnrolledCourse['course_id'] }}">
                            <div class="row g-0">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <img src="{{ asset('/storage/courseImages/' . $singleEnrolledCourse['course_image']) }}"
                                        class="img-fluid coursepicture col-md-12 col-sm-12 col-12 h-100"
                                        alt="coursepicture">
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="card-body">
                                        <h5 class="card-title pb-3">
                                            {{ $singleEnrolledCourse['course_title'] }}
                                        </h5>
                                        <p class="card-text">
                                        {{ $singleEnrolledCourse['description'] }}
                                        </p>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                                <div class="progress rounded-pill">
                                                    <div class="progress-bar rounded-pill text-end pe-2" role="progressbar"
                                                        style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100">25%</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i
                                                        class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                    {{ $singleEnrolledCourse['category_name'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i class="far fa-user pe-1"></i>
                                                    {{ $singleEnrolledCourse['instructor_firstname'] }}
                                                    {{ $singleEnrolledCourse['instructor_lastname'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                <p class="para-2"><i class="far fa-user pe-1"></i>
                                                    {{ $singleEnrolledCourse['course_difficulty'] }}
                                                </p>
                                            </div>
                                            
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                               
                                                <p class="duration"><i class="far fa-clock pe-1"></i>Next cohort:
                                                 <small> {{ $singleEnrolledCourse['start_date'] }}
                                                    </small>
                                                </p>
                                                
                                                
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



        </div>

    </section>


    <footer>
        <div class="ty-mac-footer">
            <div class="container">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-6 mb-4">
                        <h4 class="pb-2">LOGO</h4>
                        <p>At vero eos et accusamus et iusto 
                            odio dignissimos ducimus qui blanditiis
                             praesentium voluptatum deleniti atque 
                             corrupti quos dolores et quas molestias
                              excepturi sint occaecati cupiditate non 
                              provident, similique sunt in culpa qui officia deserunt 
                              mollitia animi, id est laborum et dolorum fuga.</p>
                        <h4 class="pt-2 pb-3">
                            Social Links
                        </h4>
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-12">
                                <a href=""><i class="fab fa-facebook"></i></a>
                                <a href=""><i class="fab fa-twitter ps-3"></i></a>
                                <a href=""><i class="fab fa-instagram ps-3"></i></a>
                                <a href=""><i class="fab fa-youtube ps-3"></i></a>
                                <a href=""><i class="fab fa-linkedin ps-3"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>

                    <div class="col-lg-5">
                        <h4 class="pb-3">Quick Links</h4>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                        </div>
                        
                        <div class="row">
                        <h4 class="pb-2">Help</h4>
                            <div class="col-lg-12 col-md-6 col-sm-8 col-10">
                                <a href="#">Terms and Conditions | Privacy Policy</a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="#">Cookies</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark copyRight">
            <div class="col-lg-12 d-flex justify-content-center">
                <p class="pt-2">© Copyright TY Mac 2021</p>
            </div>
        </div>
    </footer>

<script>
    document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});

    var elements = document.getElementsByClassName('card-2');
    var length = elements.length;
    for(index=0;index<length;index++) {
        console.log(elements[index]);
        elements[index].addEventListener('click', function(event) {
            let courseId = this.getAttribute('data-id');
            window.location.replace('/enrolled-course/' + courseId);
        });
    }

    document.getElementById('upcoming-tab').addEventListener('click', function(e){
        document.getElementById('upcoming').classList.add('active', 'show');
        document.getElementById('live').classList.remove('active', 'show');
    });

    document.getElementById('live-tab').addEventListener('click', function(e){
        document.getElementById('upcoming').classList.remove('active', 'show');
        document.getElementById('live').classList.add('active', 'show');
    });
</script>
@endsection('content')
