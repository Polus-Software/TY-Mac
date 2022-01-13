<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('/assets/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/loginModal.css') }}">
  <title>TY- MAC</title>
</head>
<style>
  .dropdown-menu {
  min-width: 25rem !important;
  left: -22rem !important;
  top: 2.7rem !important;
  border-radius: 15px !important;
}
.dropdown {
    display:inline-block;
    margin-left:20px;
    padding:10px;
  }


.glyphicon-bell {
   
    font-size:1.5rem;
  }

.notifications {
   min-width:420px; 
  }
  
  .notifications-wrapper {
     overflow:auto;
      max-height:250px;
    }
    
 .menu-title {
     color:#ff7788;
     font-size:1.5rem;
      display:inline-block;
      }
 
.glyphicon-circle-arrow-right {
      margin-left:10px;     
   }
  
   
 .notification-heading, .notification-footer  {
 	padding:2px 10px;
       }
      
        
.dropdown-menu.divider {
  margin:5px 0;          
  }



.item-title {
  
 font-size:1.3rem;
 color:#000;
    
}

.notifications a.content {
 text-decoration:none;
 background:#ccc;

 }
    
.notification-item {
 padding:10px;
 margin:5px;
 background:#ccc;
 border-radius:4px;
 }




</style>

<body>
@extends('header')
  <!-- top banner-->
  
  <section id="home" class="intro-section">
    <div class="container">
      <div class="row align-items-center pb-5">
        <div class="col-md-6 intros text-start">
          <h1 class="display-2 lh-1">
            <p class="welcome-text mb-0">Welcome to TY-Mac</p>
            <span class="display-2--intro">Learn new skills <br>in a <span class="fw-bold think-personalized-way-text">personalized way.
              <div class="think-personalized-way-underline"><img  class="img-fluid mx-auto d-block" src="courselist/images/Under-line.png" alt="marketing illustration"></div>
            </span></span>
          </h1>
          <!-- <div class="mb-3">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div> -->
          <div class="mt-5 mb-4">
          <ul class="ps-0">
            <li class="list-inline fs-18"><i class="fas fa-angle-double-right me-2"></i>Live instructor led courses</li>
            <li class="list-inline fs-18"><i class="fas fa-angle-double-right me-2"></i>Small class sizes</li>
            <li class="list-inline fs-18"><i class="fas fa-angle-double-right me-2"></i>Interactive learning</li>
          </ul>
          </div>
          <a type="button" class="btn btn-secondary think-btn-secondary" href="{{ route('student.courses.get') }}">Enroll now</a>
        </div>
        <div class="col-md-6 intros text-end">
          <div class="video-box">
            <img src="courselist/images/bannerhome.png" alt="video illutration" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- companies logo -->

  <section id="campanies" class="campanies d-none">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="campanies__logo-box shadow-sm">
            <img src="courselist/images/DFS_SanJose-grey.png" alt="Campany 1 logo" title="Campany 1 Logo" class="img-fluid">
          </div>
        </div>
        <div class="col-md-4">
          <div class="campanies__logo-box shadow-sm">
            <img src="courselist/images/san jose.png" alt="Campany 2 logo" title="Campany 2 Logo" class="img-fluid">
          </div>
        </div>
        <div class="col-md-4">
          <div class="campanies__logo-box shadow-sm">
            <img src="courselist/images/westvalley.webp.png" alt="Campany 3 logo" title="Campany 3 Logo" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- services -->
  <section id="services" class="services mb-5 think-services-bg think-mt-75">
    <div class="container">
      <div class="row text-center think-mb-75">
        <h1 class="display-3 fw-bold think-title-home"><span class="position-relative d-inline-block">Why we are out of Ordinary<div class="think-services-underline">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div></span></h1>
        <!-- <div class="mb-5">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div> -->
      </div>
      <div class="row pt-2 pb-2 mt-0 mb-3">
        <div class="col-md-4 border-right think-feature-box">
          <div class="p-3 text-center">
            <img src="courselist/images/setting-lines.png" alt="marketing illustration" class="img-fluid mb-4 mx-auto d-block">
            <h2 class="fw-bold text-capitalize text-center mb-4">Personalized learning</h2>
            <p class="fw-light mb-4">
              Small class sizes create a personalized learning experience
            </p>
            <!-- <a href="">learn more</a> -->
          </div>
        </div>
        <div class="col-md-4 border-right think-feature-box">
          <div class="p-3 text-center">
            <img src="courselist/images/simple_icon.png" alt="marketing illustration" class="img-fluid mb-4 mx-auto d-block">
            <h2 class="fw-bold text-capitalize text-center mb-4">Simple</h2>
            <p class="fw-light mb-4">
              Our teaching format makes it easy and fun to learn any new skill!
            </p>
            <!-- <a href="">learn more</a> -->
          </div>
        </div>
        <div class="col-md-4 think-feature-box">
          <div class="p-3 text-center">
            <img src="courselist/images/interactive.png" alt="marketing illustration" class="img-fluid mb-4 mx-auto d-block">
            <h2 class="fw-bold text-capitalize text-center mb-4">Interactive</h2>
            <p class="fw-light mb-4">
              Courses are not just taught, they are made to be interactive between the teacher and student
            </p>
            <!-- <a href="">learn more</a> -->
          </div>
        </div>
      </div>
      <div class="text-center">
      <a type="button" class="btn think-btn-secondary-outline" href="#">Learn more</a>
      </div>
    </div>
  </section>
  <!-- Our courses -->
  @php
  use App\Http\Controllers\Student\CoursesCatalogController;
  $courses = CoursesCatalogController::getAllCourses();
  @endphp


  <section id="Our courses" class="our-courses">
    <div class="container">
      <div class="row text-center think-mb-75">
        <h1 class="display-3 fw-bold think-title-home"><span class="position-relative d-inline-block">Our courses<div class="think-courses-underline">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block h-32">
        </div></span></h1>
        <!-- <div class="mb-5">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div> -->
      </div>
      <div class="row">
        <div class="col-lg-12">
        @if(!empty($courses))
          <div id="liveCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner think-carousel-home">
            @foreach($courses as $course)
              @if($loop->first)
              <div class="carousel-item active">
                <div class="row">
                  @elseif($loop->iteration % 4 == 0)
                </div>
              </div>
              <div class="carousel-item">
                <div class="row">
                  @endif
                  <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                    <div class="card-1">
                      <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                      <div class="card-body pb-0 fs-14">
                        <h5 class="card-title text-center text-truncate fs-16 fw-bold">{{ $course['course_title'] }}</h5>
                        <p class="card-text text-sm-start text-truncate">{{ $course['description'] }}</p>
                        

                        <div class="row mb-3">
                          <div class="col-lg-6 col-sm-6 col-6">
                        @for($i = 1; $i <= 5; $i++)
                        @if($i <= $course['rating'])
                        <i class="fas fa-star rateCourse"></i>
                        @else
                        <i class="far fa-star rateCourse"></i>
                        @endif
                        @endfor
                            (60)
                          </div>
                          <div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end p-0 pe-2">
                            <i class="fas fa-tag fa-flip-horizontal ps-2"></i>{{ $course['course_category'] }}
                          </div>
                        </div>

                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">
                            <div class="row">
                            <div class="col-auto item-1 px-0"><i class="far fa-clock pe-1"></i>{{ $course['duration'] }}</div>
                              <div class="col item-2 px-0 text-center">
                              <p><i class="far fa-user pe-1"></i>{{ $course['instructor_firstname'] ." ". $course['instructor_lastname']}}</p>
                              </div>
                              <div class="col-auto item-3 px-0 d-flex">
                                <p class="text-end"><i class="far fa-user pe-1"></i>{{ $course['course_difficulty'] }}</p>
                              </div>
                            </div>
                          </li>
                        </ul>
                        <div class="row py-2">
                          <div class="text-center border-top">
                            <a href="{{ route('student.course.show', $course['id'])}}" class="card-link btn d-inline-block w-100 px-0">Join now</a>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  @if($loop->last)
                </div>
              </div>
              @endif
              @endforeach
              <button class="carousel-control-prev" type="button" data-bs-target="#liveCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon bg-yellow" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#liveCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon bg-yellow" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
              @else
              <h2 style="text-align:center;">No courses to be shown! Please add courses.</h2>
            </div>
            
          </div>
          @endif
        </div>
      </div>
      <div class="row mt-3 mb-4 text-center">
        <div class="col-md-12">
          <a href="{{ route('student.courses.get') }}" class="btn think-btn-secondary-outline" type="button" style="text-decoration:none;">Explore all Courses</a>
        </div>
      </div>
    </div>

  </section>

  <section id="portfolio" class="portfolio think-portfolio-bg think-mb-75">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-md-3">
          <div class="p-4">
            <h2 id="student_count" class="fw-bold text-capitalize text-center">
              
            </h2>
            <p>Happy students</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="p-4">
            <h2 id="course_count" class="fw-bold text-capitalize text-center">
              
            </h2>
            <p>Courses</p>
          </div>
        </div>
      </div>
      
    </div>
  </section>

  <!-- THE TESTIMONIALS -->
  <section id="testimonials" class="think-testimonials">
    <div class="container">
      <div class="row text-center">
        <h1 class="display-3 fw-bold think-title-home">
          <span class="position-relative d-inline-block">
            What's our learners mind
            <div class="think-testimonial-underline">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div></h1>
        
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-5 text-start">
          <div class="services__pic">
            <img src="courselist/images/testimonials.png" alt="web development illustration" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services d-flex flex-column justify-content-center">
          <div class="services__content">
          <div><i class="fas fa-quote-left fa-3x"></i></div>
            <h3 class="fw-bold text-capitalize text-center mt-1">TY-Mac makes learning new skills incredibly simple & interactive</h3>
            <p class="lh-lg my-5">
              I signed up for the Fundamentals of Quality Analysis course without having any prior knowledge in the field, but by the time I completed the course, I became proficient in functional QA & got a job in the field! The instructor did a wonderful job at teaching the subjects in a simple way!
            </p>
            <label class="d-block text-center">YANA SIZIKOVA</label>
            <span class="d-block text-center">Software Engineer, Canada</span>
            <div class="text-end"><i class="fas fa-quote-right fa-3x ms-0"></i></div>
          </div>
        </div>
      </div>
    </div>
  </section>
<div class="my-5"><hr class="hr-line"></div>
  <section class="mb-5">
    <div class="container">
      <div class="row pt-2 pb-2 mt-0 mb-3 justify-content-center text-center">
        <div class="dotted-decoaration"><img src="/icons/dotted.svg" alt="error"></div>
        <div class="col-md-11">
          <div class="think-yellow-container bg-warning p-4 rounded-3 p-5">
            <h2 class="fw-bold text-capitalize text-center text-white mb-4">
              Have a question?
            </h2>
            <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#contactModal">CONTACT US</button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- THE FOOTER -->
  <footer class="footer">
    <div class="container mt-5">
      <div class="row text-white justify-content-center mt-3 pb-3">
        <div class="col-12 col-sm-6 col-lg-6 mx-auto">
          <h5 class="text-capitalize fw-bold">LOGO</h5>
          <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
          <p class="lh-lg">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem ex obcaecati blanditiis reprehenderit ab mollitia voluptatem consectetur?
          </p>
        </div>
        <div class="col-12 col-sm-6 col-lg-6 mx-auto">
          <h5 class="text-capitalize fw-bold">Products</h5>
          <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
          <ul class="list-inline campany-list">
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Lorem ipsum</a></li>
          </ul>
        </div>
        <div class="col-12 col-sm-6 col-lg-6 mx-auto">
          <h5 class="text-capitalize fw-bold">Social Media</h5>
          <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
          <div class="col-12 footer-sm">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-6 mx-auto">
          <h5 class="text-capitalize fw-bold">contact</h5>
          <hr class="bg-white d-inline-block mb-4" style="width: 60px; height: 2px;">
          <ul class="list-inline campany-list">
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Lorem ipsum</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- START THE COPYRIGHT INFO  -->
    <div class="footer-bottom pt-3 pb-3">
      <div class="container">
        <div class="row text-center text-white">
          <div class="col-12">
            <div class="footer-bottom__copyright">
              &COPY; Copyright 2021 <a href="#">TY-Mac</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- BACK TO TOP BUTTON  -->
  <a href="#" class="shadow btn-primary rounded-circle back-to-top">
    <i class="fas fa-chevron-up"></i>
  </a>

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
                <textarea name="message" class="form-control" id="contactMessage" placeholder="Type your message here"></textarea>
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

  <!-- login modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-container mx-auto p-3 rounded">
      <div class="modal-content border-0">
        <div class="modal-header border-0">
          <h5 class="modal-title mx-sm-5 mx-0 custom-form-header" id="loginModalLabel">Log in to account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
            <form id="loginForm" class="form" method="POST" action="{{route('user.login')}}">
              @csrf

              <div class="form-group mx-sm-5 mx-0">
                <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com" value="{{old('email')}}">
                <small>Error message</small>
                @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
              <div class="form-group mx-sm-5 mx-0">
                <label for="inputPassword" class="password-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" value="{{old('password')}}">
                <span><i class="fas fa-eye-slash" id="togglePassword" onClick="viewPassword()"></i></span>
                <small>Error message</small>
                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>

              <div class="form-group mx-sm-5 mx-0">
                <label class="form-check-label rememberme">
                  <input class="form-check-input" name="remember_me" type="checkbox"> &nbsp;Remember me</label>
              </div>

              <div class="d-grid form-group  mx-sm-5 mx-0">
                <button type="submit" class="btn btn-secondary loginBtn"><span class="button">Login</span></button>
              </div>

              <div class="text-center forgotpass">
                <span class="forgotpwd"><a href="{{ route('forget.password.get')}}"> Forgot password? </a></span>

              </div>

              <div class="text-center bottom-text">
                <span>
                  <p>Don't have an account?
                </span>
                <span class="login"><a href="" id="signup_link">&nbsp;Sign up</a></p></span>
              </div>

            </form>
          </div>
        </div>
        <div class="modal-footer border-0"></div>
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
                <span class="login"><a href="" id="loginLink">&nbsp;Login</a></p></span>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer border-0"></div>
      </div>
    </div>
  </div>
  <!-- signup modal ends -->
  <script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script>

let counterFlag = 0;
let courseCounter = 0;
let studentCounter = 0;

window.addEventListener("scroll", () => {
    let counterTop = document.getElementById('portfolio').getBoundingClientRect().top;
    if(counterTop <= 1000 && counterFlag == 0) {
        let interval = setInterval(function(event){
            counterFlag = 1;
            studentCounter++;
            courseCounter+=10;
            if(courseCounter <= 1000) {
              document.getElementById('course_count').innerHTML = courseCounter + "+";
            }
            if(studentCounter <= 50) {
              document.getElementById('student_count').innerHTML = studentCounter + "+";
            }   
        }, 100)
    }
});

    document.querySelector('#signupForm').addEventListener('submit', (e) => {
      if (firstname.value === '') {
        e.preventDefault();
        showError(firstname, 'First name is required');
      } else {
        removeError(firstname)
      }
      if (lastname.value === '') {
        e.preventDefault();
        showError(lastname, 'Last name is required');
      } else {
        removeError(lastname)
      }
      if (email.value === '') {
        e.preventDefault();
        showError(email, 'Email is required');
      } else if (!isValidEmail(email.value)) {
        e.preventDefault();
        showError(email, 'Email is not valid');
      } else {
        removeError(email)
      }
      if (password.value === '') {
        e.preventDefault();
        showError(password, 'Password is required');
      } else {
        removeError(password)
      }
      if (passwordconfirm.value === '') {
        e.preventDefault();
        showError(passwordconfirm, 'Confirm password is required');
      } else {
        removeError(passwordconfirm)
      }

      if (password.value != passwordconfirm.value) {
        e.preventDefault();
        showError(password, 'The two passwords do not match');
      } else if (password.value == passwordconfirm.value && password.value != '') {
        removeError(password)
      }

    });

    const form = document.getElementById('signupForm');
    const firstname = document.getElementById('firstName');
    const lastname = document.getElementById('lastName');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordconfirm = document.getElementById('password_confirmation');


    function showError(input, message) {
      input.style.borderColor = 'red';
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.innerText = message;
      small.style.visibility = 'visible';
    }

    function removeError(input) {
      input.style.borderColor = '#ced4da';
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.style.visibility = 'hidden';
    }

    function isValidEmail(email) {
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }
  </script>
  <script>
    document.querySelector('#loginForm').addEventListener('submit', (e) => {
      if (loginemail.value === '') {
        e.preventDefault();
        showError(loginemail, 'Email is required');
      } else {
        removeError(loginemail)
      }
      if (loginpassword.value === '') {
        e.preventDefault();
        showError(loginpassword, 'Password is required');
      } else {
        removeError(loginpassword)
      }
    });

    const loginform = document.getElementById('loginForm');
    const loginemail = document.getElementById('inputEmail');
    const loginpassword = document.getElementById('inputPassword');


    function showError(input, message) {
      input.style.borderColor = 'red';
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.innerText = message;
      small.style.visibility = 'visible';
    }

    function removeError(input) {
      input.style.borderColor = '#ced4da';
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.style.visibility = 'hidden';
    }

    document.getElementById('signup_link').addEventListener('click', function(e) {
      e.preventDefault();
      closeModal('loginModal');
      document.getElementById('signup_navlink').click();
    });

    document.getElementById('loginLink').addEventListener('click', function(e) {
      e.preventDefault();
      closeModal('signupModal');
      document.getElementById('login_navlink').click();
    });

    function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    console.log(modal);
    modal.hide();
  }
window.onload = function(e) {
  var url = window.location.href;
  
  let parameter = url.substr(url.indexOf('?'), url.length);
  if(parameter == "?redirect=true") {
      document.getElementById('login_navlink').click();
  }

      let path = "{{ route('get-notifications')}}";

      fetch(path, {
          method: 'GET',
          headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
             
          }
      }).then((response) => response.json()).then((data) => {
          // document.getElementById('notif-body').innerHTML = data.html;
      });

}



  </script>
</body>

</html>
<style>
  #search-btn {
    background-color: #fff !important;
    color: #000 !important;
    border: 1px solid #000 !important;
  }
</style>
