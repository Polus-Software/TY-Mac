@extends('Layouts.enrolledCoursePage')
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
  </style>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="">
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
          <a class="nav-link" href="{{ route('my-courses') }}">My courses</a>
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
<!-- review modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h3 class="modal-title ms-auto" id="reviewModalLabel">Add review</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="rating text-center mb-3">
            <label for="star1" class="fas fa-star rating-star" star-rating="1"></label>
            <label for="star2" class="fas fa-star rating-star" star-rating="2"></label>
            <label for="star3" class="fas fa-star rating-star" star-rating="3"></label>
            <label for="star4" class="fas fa-star rating-star" star-rating="4"></label>
            <label for="star5" class="fas fa-star rating-star" star-rating="5"></label>
        </div>
          
        <div class="col-lg-6 col-md-6 col-sm-6 col-6 comment-area m-auto ">
            <textarea class="form-control" id="comment" placeholder="Leave your comment..." rows="4" maxlength ="60"></textarea> 
        </div>                         
      </div>
       <div class="modal-footer border-0 mb-3">
           @csrf
        <button type="button" id="reviewSubmitBtn" class="col-lg-6 col-md-6 col-sm-6 col-6 btn btn-dark m-auto">Submit</button>
      </div>
    </div>
  </div>
</div>
<!-- review modal ends -->
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






<header class="d-flex align-items-center mb-3">
<!-- <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fparse.com" target="_blank">
  Share on Facebook
</a> -->
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card card-1  border-0 mb-3 mt-4">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        @foreach($singleCourseDetails as $course)
                            <img src="{{asset('/storage/courseThumbnailImages/'.$course['course_thumbnail_image'])}}" class="img-fluid col-md-12 col-sm-12 col-12 h-100" alt="coursepicture">
                        @endforeach
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card-body">
                                <h5 class="card-title pb-3">@foreach($singleCourseDetails as $course)
                                    {{ $course['course_title'] }}
                                    @endforeach
                                </h5>
                                <p class="card-text">
                                    @foreach($singleCourseDetails as $course)
                                        {{ $course['description'] }}
                                    @endforeach</p>
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
                                                    @foreach($singleCourseDetails as $course)
                                                        {{ $course['course_category'] }}
                                                    @endforeach
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                            <p class="para-1"><i class="far fa-user pe-1"></i>
                                            @foreach($singleCourseDetails as $course)
                                                {{ $course['instructor_firstname'] }} {{ $course['instructor_lastname'] }}
                                            @endforeach
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                            <p class="para-2"><i class="far fa-user pe-1"></i>
                                            @foreach($singleCourseDetails as $course)
                                                {{ $course['course_difficulty'] }}
                                            @endforeach
                                            
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                                <p class="duration"><i class="far fa-clock pe-1"></i>
                                                    Next Live Class: - <small>11/19/2021 - 9 AM IST - 10 AM IST</small>
                                                   
                                                </p>
                                                @foreach($singleCourseDetails as $course)
                                                <a href="{{ route('generate-certificate', $course['id']) }}" class="btn p-0 mb-3">Download certificate<i class="fas fa-download ps-3"></i></a>
                                                @endforeach
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6 text-end">
                                                <a class="btn btn-dark" id="reviewButton" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                                Add review
                                                </a>
                                                <input type="hidden" id="course_id" value="{{$course['id']}}">
                                                <input type="hidden" id="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

    <section>
        <div class="container flex-column">
            <div class="row mb-5">
                <div class="col-lg-3 col-md-4 col-sm-12 col-12 vertcalNav mb-3">
                    <div class="row sidebar pt-4">
                        <h3 class="text-center">Cohort Details</h3>
                        <div class="nav flex-column nav-pills d-flex align-items-start pe-0 pt-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active mb-2 ps-5 text-start" id="v-pills-cohortSchedule-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cohortSchedule" type="button" role="tab" aria-controls="v-pills-cohortSchedule" aria-selected="true">
                                <i class="far fa-clock pe-3"></i>Cohort Schedule
                            </button>
                            <button class="nav-link mb-2 ps-5 text-start" id="v-pills-personalizedRecommondations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-personalizedRecommendations" type="button" role="tab" aria-controls="v-pills-CohortQuestions" aria-selected="false">
                                <img src="" alt="" class="pe-2">Personalized recommendations
                            </button>
                            <button class="nav-link mb-2 ps-5 text-start" id="v-pills-CohortQuestions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-CohortQuestions" type="button" role="tab" aria-controls="v-pills-CohortQuestions" aria-selected="false">
                                <img src="" alt="" class="pe-2">Cohort Q&A
                            </button>
                            <button class="nav-link mb-2 ps-5 text-start" id="v-pills-cohortInfo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cohortInfo" type="button" role="tab" aria-controls="v-pills-cohortInfo" aria-selected="false">
                                <img src="" alt="" class="pe-2">Cohort Info
                            </button>
                            <button class="nav-link mb-2 ps-5 text-start" id="v-pills-assignments-tab" data-bs-toggle="pill" data-bs-target="#v-pills-assignments" type="button" role="tab" aria-controls="v-pills-assignments" aria-selected="false">
                                <img src="" alt="" class="pe-2">Assignments
                            </button>
                           
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 border-bottom mt-3 mb-3"></div>
                            <p class="ps-5 text-start align-items-start achievement">ACHIEVEMENTS</p>
                            
                                <div class="container">
                                    <div class="badge-shadow left-0"><img src="/Badges/Badge 1.svg" alt=""></div>
                                    <div class="badge-shadow left--15"><img src="/Badges/Badge 2.svg" alt=""></div>
                                    <div class="badge-shadow left--30"><img src="/Badges/Badge 3.svg" alt=""></div>
                                        <div class="badge-shadow left--45">
                                            <button class="nav-link bg-transparent p-0" id="v-pills-achievements-tab" data-bs-toggle="pill" data-bs-target="#v-pills-achievements" type="button" role="tab" aria-controls="v-pills-achievements" aria-selected="false">
                                                <img src="/Badges/More.svg" alt="">
                                            </button>
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>
                   
                <div class="col-lg-9 col-md-8 col-sm-12 col-12 gx-5">
                    <div class="tab-content" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="v-pills-cohortSchedule" role="tabpanel" aria-labelledby="v-pills-cohortSchedule">
                            <div class="card card-2 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title border-bottom pt-2 pb-2">Session info</h5>
                                    @foreach($topicDetails as $topicDetail)
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h6 class="card-title pt-2" data-id="{{ $topicDetail['topic_id'] }}">{{ $topicDetail['topic_title'] }}</h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end">
                                            <button type="button" class="btn"><i class="fas fa-undo pe-2"></i>View again</button>
                                        </div>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush border-bottom pb-3">
                                        @foreach($topicDetail['topic_content'] as $content)
                                            <li class="ms-4 border-0 pb-2" style="list-style:circle;">{{ $content->topic_title }}</li>
                                        @endforeach
                                    </ul>   
                                    @endforeach                                    
                                </div>
                            </div>

                            <div class="row border-bottom">
                                <div class="col-lg-12">
                                    <h5 class="recommendation">Recommended Topics to Review</h5>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                            @foreach($recommendations as $recommendation)
                                <div class="col-lg-6 mb-3">
                                    <div class="card card-3" style="height: 560px;">
                                        <img src="/courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a href="#" class="btn btn-primary w-100">View again</a>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="card card-4">
                                                        <div class="card-body">
                                                          We recommend that you view this topic again.
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h6 class="card-title">{{ $recommendation['topic_title'] }}</h6>
                                                    <ul class="list-group list-group-flush border-bottom pb-3">
                                                        <li class=" ms-4 border-0 pb-2">{{ $recommendation['content_title'] }}</li>
                                                    </ul>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                        </div>

                        <div class="tab-pane fade" id="v-pills-personalizedRecommendations" role="tabpanel" aria-labelledby="v-pills-personalizedRecommendations-tab">
                        
                            <div class="row border-bottom">
                                <div class="col-lg-12">
                                    <h5 class="heading-1">Recommended Topics to Review</h5>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                                <div class="col-lg-6 mb-3">
                                    <div class="card card-3" style="height: 550px;">
                                        <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top img-fluid" alt="...">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a href="#" class="btn btn-primary w-100">View again</a>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="card card-4">
                                                        <div class="card-body">
                                                            We recommend you to view again these topics.
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-5">
                                                        <div class="card-body">
                                                        <h6 class="card-title">Session 1 - Intro to G Suite & Google Drive</h6>
                                                            <ul class="list-group list-group-flush pb-3">
                                                                <li class=" ms-4 border-0 pb-2">How to use Google Suite</li>
                                                                <li class=" ms-4 border-0 pb-2">How to use Google Drive</li>
                                                            </ul>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-lg-6">
                                    <div class="card card-3" style="height: 550px;">
                                        <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a href="#" class="btn btn-primary w-100">View again</a>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="card card-4">
                                                        <div class="card-body">
                                                          <p class="card-text">This is some text within a card body.</p>
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card card-5">
                                                        <div class="card-body">
                                                            <h6 class="card-title">Session 1 - Intro to G Suite & Google Drive</h6>
                                                            <ul class="list-group list-group-flush pb-3">
                                                                <li class="ms-4 border-0 pb-2">How to use Google Suite</li>
                                                                <li class="ms-4 border-0 pb-2">How to use Google Drive</li>
                                                                <li class="ms-4 border-0 pb-2">How to use Google Suite</li>
                                                                <li class="ms-4 border-0 pb-2">How to use Google Drive</li>
                                                            </ul>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                        <div class="tab-pane fade" id="v-pills-CohortQuestions" role="tabpanel" aria-labelledby="v-pills-CohortQuestions-tab">
                           <div class="row">
                               <div class="col-lg-12">
                                <div class="card card-6">
                                    <div class="card-body">
                                        <div class="row border-bottom">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                <h5 class="card-title">Questions & Answers</h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end">
                                                <button type="button" class="btn">Ask a question</button>
                                            </div>
                                            
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                                <img src="courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:40px; height:40px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <p class="card-title text-left">
                                                            Lorem ipsum dolor sit amet.
                                                        </p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <p class="text-end time">4 months ago</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <p class="para-1">Lorem ipsum dolor sit amet. Sed aliquid voluptatem id incidunt 
                                                               quaerat in nihil tempore rem quam sint. Aut itaque officia et 
                                                               soluta molestiae rem iusto distinctio qui alias accusantium et veniam voluptatum.
                                                               Et voluptatem sunt vel Quis labore vel laborum
                                                               repellendus eum galisum blanditiis.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ps-5">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-center ps-5">
                                                @foreach($singleCourseDetails as $course)
                                                <img src="{{asset('/storage/images/'.$course['profile_photo'])}}" class="img-fluid rounded-circle mt-3" alt="..." style="width:40px; height:40px;">
                                                @endforeach
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                                <p class="card-title text-left">
                                                                @foreach($singleCourseDetails as $course)
                                                               {{ $course['instructor_firstname'] }} {{ $course['instructor_lastname'] }} &nbsp;{{ $course['designation'] }} at  {{ $course['institute'] }}
                                                               @endforeach
                                                           
                                                            </p>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                                <p class="text-end time">4 months ago</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <p class="para-1">Lorem ipsum dolor sit amet. Sed aliquid voluptatem id incidunt 
                                                                   quaerat in nihil tempore rem quam sint. Aut itaque officia et 
                                                                   soluta molestiae rem iusto distinctio qui alias accusantium et veniam voluptatum.
                                                                   Et voluptatem sunt vel Quis labore vel laborum
                                                                   repellendus eum galisum blanditiis.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                                <img src="courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:40px; height:40px;">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <h5 class="card-title text-left">
                                                            Lorem ipsum dolor sit amet.
                                                            </h5>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <p class="text-end time">4 months ago</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <p class="para-1">Lorem ipsum dolor sit amet. Sed aliquid voluptatem id incidunt 
                                                               quaerat in nihil tempore rem quam sint. Aut itaque officia et 
                                                               soluta molestiae rem iusto distinctio qui alias accusantium et veniam voluptatum.
                                                               Et voluptatem sunt vel Quis labore vel laborum
                                                               repellendus eum galisum blanditiis.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ps-5">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-center ps-5">
                                                    <img src="courselist/Avatar Instructor.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:40px; height:40px;">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <h5 class="card-title text-left">
                                                                @foreach($singleCourseDetails as $course)
                                                               {{ $course['instructor_firstname'] }}   {{ $course['instructor_lastname'] }}
                                                                @endforeach
                                                           
                                                                </h5>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <p class="text-end time">4 months ago</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <p class="para-1">Lorem ipsum dolor sit amet. Sed aliquid voluptatem id incidunt 
                                                                   quaerat in nihil tempore rem quam sint. Aut itaque officia et 
                                                                   soluta molestiae rem iusto distinctio qui alias accusantium et veniam voluptatum.
                                                                   Et voluptatem sunt vel Quis labore vel laborum
                                                                   repellendus eum galisum blanditiis.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>

                                      
                                    </div>
                                </div>
                               </div>
                           </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-cohortInfo" role="tabpanel" aria-labelledby="v-pills-cohortInfo-tab">
                 
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-7">
                                        <div class="card-body p-4">
                                            <h5 class="card-title">Course description</h5>
                                            <p class="card-text-1">
                                            @foreach($singleCourseDetails as $course)
                                                {{ $course['description'] }}
                                            @endforeach
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="card card-8 mb-5">
                                        <div class="row g-0 border-bottom" style=" background:#F8F7FC; border-radius:10px 10px 0px 0px;">
                                                <div class="col-lg-2 col-sm-4 col-4">
                                                @foreach($singleCourseDetails as $course)
                                                <img src="{{asset('/storage/images/'.$course['profile_photo'])}}" class="img-fluid rounded-circle m-2 p-2 d-flex align-items-center" 
                                                alt="..." style="width:94px; height:94px;">
                                                @endforeach
                                               
                                                
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-8">
                                            <div class="card-body">
                                                <h5 class="instructor-name pt-2">
                                                @foreach($singleCourseDetails as $course)
                                                {{ $course['instructor_firstname'] }}   {{ $course['instructor_lastname'] }}
                                                @endforeach
                                                </h5>
                                                <p class="card-text-1">
                                                @foreach($singleCourseDetails as $course)
                                                {{ $course['designation'] }} at   {{ $course['institute'] }}
                                                @endforeach</p>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="card-text-1 p-3">
                                                @foreach($singleCourseDetails as $course)
                                                {{ $course['instructorDescription'] }}
                                                @endforeach</p>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <p><a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorTwitter']}}
                                            @endforeach"><i class="fab fa-twitter pe-2"></i></a>
                                                    <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorLinkedin']}}
                                            @endforeach"><i class="fab fa-linkedin-in pe-2"></i></a>
                                                    <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorYoutube']}}
                                            @endforeach"><i class="fab fa-youtube"></i></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-assignments" role="tabpanel" aria-labelledby="v-pills-assignments-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-2">
                                        <div class="card-body p-4">
                                        <h5 class="card-title border-bottom pt-2 pb-2">Assignment info</h5>
                                           
                                            @php ($slno = 0)
                                            @foreach($topicDetails as $topicDetail)
                                            @php ($slno = $slno + 1)
                                            <h6 class="card-title pt-2" id="{{$topicDetail['topic_id']}}">Session {{$slno}} - {{$topicDetail['topic_title']}}</h6>
                                            <ul class="list-group list-group-flush border-bottom pb-3 mt-3">
                                                    @foreach($topicDetail['assignmentList'] as $assignment)
                                                    <a href="{{ route('student.course.assignment', $assignment['id'] ) }}" style="text-decoration:none;">
                                                    <li class="ms-4 border-0 pb-2" style="list-style:circle;" id="{{$assignment['id']}}">
                                                    {{$assignment['assignment_title']}}
                                                    </li>
                                                    </a>
                                                @endforeach
                                                </ul>
                                            @endforeach
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-achievements" role="tabpanel" aria-labelledby="v-pills-achievements-tab">
                            <div class="card card-8 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title border-bottom pt-2 pb-2">Badges Earned</h5>
                                        <div class="row earned-badges pt-5 pb-5 d-flex mb-3">
                                        @foreach($achievedBadgeDetails as $achievedBadgeDetail)
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="{{ asset('/storage/achievementBadges/'.$achievedBadgeDetail['badge_image']) }}" alt="badge" class="ms-3">  
                                                <p class="col-lg-12 badges ps-2 m-0"> {{$achievedBadgeDetail['badge_name']}}</p>
                                                <small> {{$achievedBadgeDetail['badge_created_at']}}</small>
                                            </div>
                                            @endforeach
                                           
                                        </div>
                                     
                                        <h5 class="card-title border-bottom pt-2 pb-2">Upcoming Badges</h5>
                                        <div class="row pt-5 pb-5 d-flex justify-content-start ps-3">
                                        @foreach($upcoming as $upcomingBadge)
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="{{ asset('/storage/achievementBadges/'.$upcomingBadge['badge_image']) }}" alt="">  
                                                <p class="col-lg-12 badges m-0">{{ $upcomingBadge['badge_name'] }}</p>
                                                <!-- <small>-----</small> -->
                                            </div>
                                        @endforeach
                                        </div>

                                        <h5 class="card-title border-bottom pt-2 pb-2 mb-4">Badge List</h5>
                                        @foreach($badgesDetails as $badgesData)
                                        <div class="row d-flex justify-content-start ps-3 mb-3 mt-3">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                            <img src="{{ asset('/storage/achievementBadges/'.$badgesData['badge_image']) }}" alt=""> 
                                                <p class="col-lg-12 badges m-0 card-title">{{ $badgesData['badge_name'] }}</p>
                                                <small>---</small>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                <p class="badges">{{ $badgesData['badge_name'] }}</p>
                                                <p>{{ $badgesData['badge_description'] }}</p>
                                            </div>  
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                       
                    </div>
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
        <div class="row bg-dark copyRight">
            <div class="col-lg-12 d-flex justify-content-center">
                <p class="pt-2">© Copyright TY Mac 2021</p>
            </div>
        </div>
    </footer>



<script>
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

   document.getElementById('reviewModal').addEventListener('hide.bs.modal',function(event){
      let starElement = document.getElementsByClassName('rating-star');
      for (var i = 0; i < 5 ; i++) {
          starElement[i].classList.remove("active-stars");
      }
      document.getElementById('comment').value = "";
   });

   document.getElementById('reviewSubmitBtn').addEventListener('click', (event) => {
    
       let courseId = document.getElementById('course_id').value;
       let userId = document.getElementById('user_id').value;
       let comment =document.getElementById('comment').value;

       let path = "{{ route('student.course.review.post') }}?course_id=" + courseId + "&user_id=" + userId + "&comment=" + comment + "&rating=" + finalRating;
       //console.log(path);
        fetch(path, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            },
           body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
            if (data.status =='success'){
                closeModal('reviewModal');
                window.location.reload();
            }
        });

   });
   
   function closeModal(modalId) {
        const truck_modal = document.querySelector('#' + modalId);
        const modal = bootstrap.Modal.getInstance(truck_modal);    
        modal.hide();
    }
</script>
@endsection('content')