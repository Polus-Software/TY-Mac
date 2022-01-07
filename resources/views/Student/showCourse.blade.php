@extends('Layouts.showCourse')
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
.question-btn {
    border: 1px solid #FFFFFF;
    color: #FFFFFF;
    background: #2C3443;
    border-radius: 10px;
    width: 190px;
    height: 40px;
    font-size: 14x;
    font-weight: bold;
    font-family: 'Roboto', sans-serif;
}
  </style>

  
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm p-3 mb-5 bg-body">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6">
          @csrf
        <input id="search-box" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
      </form>

      <ul class="navbar-nav me-2">
      @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="{{ route('edituser') }}"><img src="{{ asset('/storage/images/'.Auth::user()->image) }}" class="img-fluid rounded-circle float-start me-2 mt-1" alt="" style="width:20px; height:20px;"> {{Auth::user()->firstname}}</a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('student.courses.get') }}">All Courses</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Apply to be an instructor?</a>
        </li> -->
        @if (Auth::check())
        @if(Auth::user()->role_id == 3)

        <li class="nav-item">
        <a class="nav-link" href="{{ route('assigned-courses') }}">Assigned Courses</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item">
        <a class="nav-link" href="{{ route('my-courses') }}">My courses</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @endif
        @else
        <li class="nav-item">
          <a class="nav-link" href="#">Apply to be an instructor?</a>
        </li>
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
<!-- end login modal -->

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
<!-- contact modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-container mx-auto p-3 rounded">
      <div class="modal-content border-0">
        <div class="modal-header border-0">
          <h5 class="modal-title mx-sm-5 mx-0 custom-form-header" id="contactModalLabel">Contact us</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
            <form id="contactForm" class="form" method="POST" action="{{route('user.contact')}}">
              @csrf
              <div class="form-group mx-sm-5 mx-0">
                <label for="name" class="name-label">Name</label>
                <input type="text" name="name" class="form-control" id="contactName" placeholder="Eg: Andrew Bernard">
                <small>Error message</small>
              </div>
              <div class="form-group mx-sm-5 mx-0">
                <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="contactEmail" placeholder="Eg: xyz@domainname.com">
                <small>Error message</small>
              </div>
              <div class="form-group mx-sm-5 mx-0">
                <label for="phone" class="phone-label">Phone</label>
                <input type="tel" name="phone" class="form-control" id="contactPhone" placeholder="Eg: +1 202-555-0257">
                <small>Error message</small>
              </div>
              <div class="form-group mx-sm-5 mx-0">
                <label for="message" class="message-label">Message</label>
                <textarea type="tel" name="message" class="form-control" id="contactMessage" placeholder="Type your message here"></textarea>
                <small>Error message</small>
              </div>
              <div class="d-grid form-group  mx-sm-5 mx-0">
                <button type="submit" class="btn btn-secondary sendContactInfo"><span class="button">Submit</span></button>
              </div>

            </form>
          </div>
        </div>
        <div class="modal-footer border-0"></div>
      </div>
    </div>
  </div>
  <!-- contact modal ends -->
    <header class="ty-mac-header-bg d-flex align-items-center mt-3">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-6 col-md-12 order-2 order-lg-1 p-3 ">
               
                <div class="text-content-wrapper w-100 text-lg-start">
                    <p>@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['course_title']}}
                    @endforeach
                    </p>
                </div>
                <div class="row row-1">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-3">
                        <p class="border-end"><i class="far fa-clock"></i>@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['duration']}}
                    @endforeach</p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                        <p class="border-end">@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['course_difficulty']}}
                    @endforeach</p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-5 col-5 p-0">
                        <p class="ms-2">@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['course_category']}}
                    @endforeach</p>
                    </div>
                </div>
                <div class="row row-2">
                    <div class="col-lg-12">
                        <p class="para-1">What You'll Learn</p>
                        @foreach($short_description as $value)
                        <p class="para-2"><i class="fas fa-check-circle"></i> &nbsp; {{$value}} <br>
                        @endforeach
                    </p>
                       
                    </div>
                </div>
                <div class="row row-3 pt-2">
                    <div class="col-lg-6">
                        <p class="para-3">Instructed by <strong class="text-capitalize">
                        @foreach($singleCourseDetails as $singleCourseDetail)
                          {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                        @endforeach
                        </strong></p>
                    </div>
                    <div class="col-lg-6">
                        <p>Upcoming Cohort: <strong>11/10/2021</strong></p>
                    </div>
                </div>
                
                <div class="row pt-2">
                @unless($userType == 'admin' ||  $userType == 'instructor' || $userType == 'content-creator')
                    @if($enrolledFlag == false)
                    <div class="col-lg-4 col-md-4 col-sm-4 col-6 mb-3">
                        <a class="btn enroll-button" id="enrollButton">
                            Enroll now
                        </a>
                        <input type="hidden" id="course_id" value="{{$singleCourseDetail['id']}}">
                        <input type="hidden" id="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                    </div>
                    @else
                     <h6>Already enrolled!</h6>
                    @endif
                    <a class="btn question-btn" type="button" data-bs-toggle="modal" data-bs-target="#contactModal"><i class="far fa-comment-alt"></i> Have a question?</a>
                @endunless
                </div>
                <div class="row mt-2">
                   @foreach($singleCourseDetails as $singleCourseDetail)
                        <div class="col-lg-12">
                        <span class="fw-bold">share this course: </span>
                            <a class="btn" target="_blank" href="http://www.facebook.com/sharer.php?s=100&p[title]= <?php echo urlencode ($singleCourseDetail['course_title']);?>&amp;p[summary]=<?php echo urlencode($singleCourseDetail['description']) ?>&amp;p[url]=<?php echo urlencode( url('/')); ?>&amp;p[images][0]=<?php echo urlencode('/storage/courseImages/'.$singleCourseDetail['course_image']); ?>">
                            <i class="fab fa-facebook fa-lg btn-dark me-3"></i></a>

                            <!-- <a href="https://twitter.com/intent/tweet?url=https://enliltdev.fibiweb.com/show-course/{{$singleCourseDetail['id']}}" rel="me" title="Twitter" target="_blank"><i class="fab fa-twitter-square fa-lg btn-dark"></i></a> -->
                        </div>
                    @endforeach
                </div>
              </div>
             
              <div class="col-lg-6 col-md-12 order-1 order-lg-2">
                  <img src="{{asset('/storage/courseImages/'.$singleCourseDetail['course_image'])}}" alt="course-image" 
                  class="img-fluid course-picture" style="height: auto;">
              </div>
              <div class="row">
                  
              </div>
          </div>
      </div>
    </header>

    <!-- course description -->
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-1">
                        <div class="card-body p-4">
                          <h5 class="card-title">Course description</h5>
                          @foreach($singleCourseDetails as $singleCourseDetail)
                            <p class="card-text-1">{{$singleCourseDetail['description']}}</p>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- course description end -->
<!-- course content-->
    <section class="mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-2 mb-3">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-2">Course Content</h5>
                            @php ($slno = 0)
                            @foreach($courseContents as $courseContent)
                            @php ($slno = $slno + 1)
                            <h6 class="card-subtitle mt-3"> Session {{$slno}} - {{$courseContent['topic_title']}}</h6>
                            <ul class="list-group list-group-flush border-bottom pb-3 mt-3">
                                @foreach($courseContent['contentsData'] as $content)
                                    <li class="ms-4 border-0 pb-2" style="list-style:circle;" id="{{$content['topic_content_id']}}">{{$content['topic_title']}}</li>
                                @endforeach
                            </ul>
                            @endforeach 
                        </div>
                    </div>
<!-- course content end-->
<!-- Who this course is for -->
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-body p-3">
                            <h5 class="card-title p-2">Who this course is for</h5>
                            <p class="card-text-1 p-2">@foreach($singleCourseDetails as $singleCourseDetail)
                               {{$singleCourseDetail['course_details']}}</p>
                                @endforeach
                             @foreach($course_details_points as $course_details_point)
                             @if($course_details_point != '')
                             <p class="card-text-1"><i class="far fa-check-circle"></i> &nbsp;{{$course_details_point}} </p>
                             @endif
                             @endforeach
                        </div>
                    </div>
                </div>
            </div>
<!-- instructor profile -->
            <div class="col-lg-4">
                <div class="card card-3 mb-3">
                    <div class="row g-0 border-bottom" style=" background:#F8F7FC; border-radius:10px 10px 0px 0px;">
                         <div class="col-lg-4 col-sm-4 col-4">
                         @foreach($singleCourseDetails as $singleCourseDetail)
                           <img src="{{ asset('/storage/images/'.$singleCourseDetail['profile_photo']) }}" class="img-fluid rounded-circle m-2 p-2 d-flex align-items-center" 
                           alt="..." style="width:94px; height:94px;">
                           @endforeach
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8">
                        <div class="card-body">
                          <h5 class="card-title pt-2">
                            @foreach($singleCourseDetails as $singleCourseDetail)
                              {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                            @endforeach</h5>
                          <p class="card-text-1"> 
                          @foreach($singleCourseDetails as $singleCourseDetail)
                          {{$singleCourseDetail['designation']}} at {{$singleCourseDetail['institute']}}</p>
                          @endforeach
                          
                             
                        </div>
                        </div>
                    </div>
                      <div class="row">
                          <div class="col-md-12">
                              <p class="card-text-1 p-3" style="line-height: 32px;">
                              @foreach($singleCourseDetails as $singleCourseDetail)
                              {{$singleCourseDetail['instructorDescription']}}
                              @endforeach
                              </p>
                          </div>
                           
                                <div class="row d-flex justify-content-center mb-2">
                                    <div class="col-1">
                                      <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                       {{$singleCourseDetail['instructorTwitter']}}
                                        @endforeach">
                                        <i class="fab fa-twitter"></i>
                                      </a>
                                    </div>
                                <div class="col-1">
                                    <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorLinkedin']}}
                                            @endforeach">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                                <div class="col-1">
                                    <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                            {{$singleCourseDetail['instructorYoutube']}}
                                            @endforeach">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </div>
                            </div>
                         
                      </div>
                     
                  </div>
<!-- instructor profile end -->    
<!-- live cohorts -->      
                  <div class="card card-4 mb-3 mt-3" style="background: #F8F7FC;">
                    <div class="card-body">
                        <h5 class="card-title p-3">Upcoming Live Cohorts</h5>
                        @foreach($liveSessions as $liveSession)
                            <div class="row g-0 border-bottom">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <img src="/courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block p-2" alt="...">
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a style="text-decoration:none;color:#2C3443;" href="{{ route('session-view', 7) }}">{{$liveSession['session_title']}}</a>
                                        </h5>
                                        <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- live cohorts end --> 
<!-- student reviews --> 
    <section>
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card card-5 mb-2">
                        <div class="card-body">
                            <h5 class="card-title p-3">Student Reviews</h5>
                            <div class="row">
                              @foreach($singleCourseFeedbacks as $singleCourseFeedback)
                                <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                    <img src="{{asset('/storage/images/'.$singleCourseFeedback['studentProfilePhoto'])}}" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                                    <div class="card-body">
                                        <h5 class="card-title text-left">
                                            {{$singleCourseFeedback['studentFirstname']}} {{$singleCourseFeedback['studentLastname']}}</h5>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                            @for($i = 1; $i<=5; $i++)
                                            @if($i <= $singleCourseFeedback['rating'])
                                              <i class="fas fa-star rateCourse"></i>
                                              @else
                                              <i class="far fa-star rateCourse"></i>
                                            @endif
                                            @endfor
                                               {{$singleCourseFeedback['created_at']}} 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="card-text-1 p-2 review border-bottom">
                                            {{$singleCourseFeedback['comment']}} 
                                        </p>
                                    </div>  
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
<!-- student reviews end--> 
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
        <div class="row bg-dark copyRight">
            <div class="col-lg-12 d-flex justify-content-center">
                <p class="pt-2">© Copyright TY Mac 2021</p>
            </div>
        </div>
    </footer>


<script>
    document.getElementById('enrollButton').addEventListener('click', (e) => {
    e.preventDefault();
    let path ="{{ route('student.course.enroll') }}";
    fetch(path, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            },
            
        }).then((response) => response.json()).then((data) => {
           if (data.status =='success'){
            let courseId = document.getElementById('course_id').value;
            window.location.href ="/register-course?id="+courseId;
            
           }else{
               let loginModal = new bootstrap.Modal(
               document.getElementById("loginModal"),{
               });
               loginModal.show();
           }
        });
    });


   let finalRating = 0;
   
   let stars = document.getElementsByClassName('rating-star');
   for(var index = 0; index < stars.length; index++){
       stars[index].addEventListener('click', function (event){
           let starRating = parseInt(this.getAttribute('star-rating'));

            for(var i = 0; i < starRating; i++) {
                stars[i].classList.add("active-stars");
            }
            for(var i = starRating; i < index; i++) {
                console.log(i);
                stars[i].classList.remove("active-stars");
            }
           finalRating= starRating; 
   });
   }
   
   
   function closeModal(modalId) {
        const truck_modal = document.querySelector('#' + modalId);
        const modal = bootstrap.Modal.getInstance(truck_modal);    
        modal.hide();
    }

    document.querySelector('#loginForm').addEventListener('submit', function(e) {
        if(loginemail.value === '') {
            e.preventDefault();
            showError(loginemail,'Email is required');
        }else {
            removeError(loginemail);
        }
        if(loginpassword.value === '') {
            e.preventDefault();
            showError(loginpassword,'Password is required');
        } else {
            removeError(loginpassword);
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
<script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
@endsection('content')