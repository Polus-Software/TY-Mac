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
  <link rel="stylesheet" href="{{ asset('/assets/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/assets/loginModal.css') }}">
  <title>TY- MAC</title>
</head>

<body>
  <!-- NAVBAR SECTION  -->
  @if(Auth::check())
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler nav-bar-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6 col-md-9 col-sm-9 col-6">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
      </form>

      <ul class="navbar-nav">
      @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="{{ route('edituser') }}">Welcome, {{Auth::user()->firstname}}</a>
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
  @else
  <nav class="navbar navbar-expand-lg fixed-top llp-navbar navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="">
        LOGO
      </a>
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6 col-md-9 col-sm-9 col-6">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
      </form>
      <button class="navbar-toggler nav-bar-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav" style="width:max-content;">
          <li class="nav-item"><a class="nav-link active" aria-curent="page" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('student.courses.get')}}">All Courses</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Apply to be an instructor</a></li>
          <li class="nav-item"><a class="nav-link" href="#signup" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</a></li>
          <li class="nav-item"><a class="nav-link" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  @endif
  <!-- top banner-->
  <section id="home" class="intro-section">
    <div class="container">
      <div class="row align-items-center pb-5">
        <div class="col-md-6 intros text-start">
          <h1 class="display-2">
            <span class="display-2--intro">Learn new skills in a personalized way.</span>
          </h1>
          <ul>
            <li class="list-inline"><i class="fas fa-angle-double-right mx-2"></i>Live instructor led courses</li>
            <li class="list-inline"><i class="fas fa-angle-double-right mx-2"></i>Small class sizes</li>
            <li class="list-inline"><i class="fas fa-angle-double-right mx-2"></i>Interactive learning</li>
          </ul>
          <button type="button" class="btn btn-secondary">Enroll now</button>
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

  <section id="campanies" class="campanies">
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
  <section id="services" class="services mb-5">
    <div class="container">
      <div class="row text-center">
        <h1 class="display-3 fw-bold">Why we are out of Ordinary</h1>
        <div class="mb-5">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div>
      </div>
      <div class="row pt-2 pb-2 mt-0 mb-3">
        <div class="col-md-4 border-right">
          <div class="bg-white p-3 text-center">
            <img src="courselist/images/setting-lines.png" alt="marketing illustration" class="img-fluid mb-4 mx-auto d-block">
            <h2 class="fw-bold text-capitalize text-center mb-4">Personalized learning</h2>
            <p class="fw-light mb-4">
              Small class sizes create a personalized learning experience
            </p>
            <a href="">learn more</a>
          </div>
        </div>
        <div class="col-md-4 border-right">
          <div class="bg-white p-3 text-center">
            <img src="courselist/images/simple_icon.png" alt="marketing illustration" class="img-fluid mb-4 mx-auto d-block">
            <h2 class="fw-bold text-capitalize text-center mb-4">Simple</h2>
            <p class="fw-light mb-4">
              Our teaching format makes it easy and fun to learn any new skill!
            </p>
            <a href="">learn more</a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="bg-white p-3 text-center">
            <img src="courselist/images/interactive.png" alt="marketing illustration" class="img-fluid mb-4 mx-auto d-block">
            <h2 class="fw-bold text-capitalize text-center mb-4">Interactive</h2>
            <p class="fw-light mb-4">
              Courses are not just taught, they are made to be interactive between the teacher and student
            </p>
            <a href="">learn more</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Our courses -->
  @php
  use App\Http\Controllers\Student\CoursesCatalogController;
  $courses = CoursesCatalogController::getAllCourses();
  @endphp


  <section id="Our courses" class="services">
    <div class="container">
      <div class="row text-center">
        <h1 class="display-3 fw-bold">Our courses</h1>
        <div class="mb-5">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div id="liveCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
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
                      <div class="card-body">
                        <h5 class="card-title text-center">{{ $course->course_title }}</h5>
                        <p class="card-text text-sm-start text-truncate">{{ $course->description }}</p>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">
                            <div class="row">
                              <div class="col-lg-6 col-sm-6 col-6">
                                <p><i class="far fa-user pe-1"></i>{{ $course->firstname ." ". $course->lastname}}</p>
                              </div>
                              <div class="col-lg-6 col-sm-6 col-6">
                                <p class="text-end"><i class="far fa-user pe-1"></i>{{ $course->course_difficulty }}</p>
                              </div>
                            </div>
                          </li>
                        </ul>
                        <div class="row bg-light">
                          <div class="text-center border-top">
                            <a href="{{ route('student.course.show', $course->course_id)}}" class="card-link btn">Join now</a>
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
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#liveCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#liveCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
      <div class="row mt-5 mb-4 g-3 text-center">
        <div class="col-md-12">
          <a href="{{ route('student.courses.get') }}" class="btn btn-outline-primary" type="button" style="text-decoration:none;">Explore all Courses</a>
        </div>
      </div>
    </div>

  </section>

  <section id="portfolio" class="portfolio">
    <div class="container">
      <div class="row pt-2 pb-2 mt-0 mb-3 justify-content-center text-center">
        <div class="col-md-3">
          <div class="bg-white p-4">
            <h2 class="fw-bold text-capitalize text-center">
              1000+
            </h2>
            <p class="fw-light">Happy students</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="bg-white p-4">
            <h2 class="fw-bold text-capitalize text-center">
              1000+
            </h2>
            <p class="fw-light">Courses</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- THE TESTIMONIALS -->
  <section id="testimonials" class="mb-5">
    <div class="container">
      <div class="row text-center">
        <h1 class="display-3 fw-bold">What's our learners mind</h1>
        <div class="mb-5">
          <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-start">
          <div class="services__pic">
            <img src="courselist/images/testimonials.png" alt="web development illustration" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
          <div class="services__content">
            <h3 class="fw-bold text-capitalize text-center mt-1">TY-Mac makes learning new skills incredibly simple & interactive</h3>
            <p class="lh-lg">
              I signed up for the Fundamentals of Quality Analysis course without having any prior knowledge in the field, but by the time I completed the course, I became proficient in functional QA & got a job in the field! The instructor did a wonderful job at teaching the subjects in a simple way!
            </p>
            <span>YANA SIZIKOVA</span><span>Software Engineer, Canada</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="mb-5">
    <div class="container">
      <div class="row pt-2 pb-2 mt-0 mb-3 justify-content-center text-center">
        <div class="col-md-10">
          <div class="bg-warning p-4 rounded-3 p-5">
            <h2 class="fw-bold text-capitalize text-center text-white mb-4">
              Have a question?
            </h2>
            <button class="btn btn-secondary" type="button">CONTACT US</button>
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
                <span class="login"><a href="{{ route('signup') }}">&nbsp;Sign up</a></p></span>
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
  <script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script>
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
