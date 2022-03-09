

@php

  use App\Models\UserType;
  use App\Models\User;
 
  $user = Auth::user();
  $userType = "";
  if($user) {
    $userId = $user->role_id;

    $userType = UserType::where('id', $userId)->value('user_role');
  }
@endphp
@if($userType == "instructor") 
  <script type="text/javascript">
    window.location = "/assigned-courses";
  </script>   
@endif

@extends('Layouts.app')
@section('content')
<!-- top banner-->

<section id="home" class="intro-section">
  <div class="container">
    <div class="row align-items-center pb-5">
      <div class="col-md-6 intros text-start">
        <h1 class="display-2 lh-1">
          <p class="welcome-text mb-0">Welcome to ThinkLit</p>
          <span class="display-2--intro">Learn new skills <br>in a <span class="fw-bold think-personalized-way-text">personalized way.
              <div class="think-personalized-way-underline"><img class="img-fluid mx-auto d-block" src="courselist/images/Under-line.png" alt="marketing illustration"></div>
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
      <h1 class="display-3 fw-bold think-title-home"><span class="position-relative d-inline-block">The ThinkLit Way<div class="think-services-underline">
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
  </section>
  <!-- recommendation feature -->
  <section id="testimonials" class="think-rec-engine">
  <div class="container">
    <div class="row">      
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services d-flex flex-column justify-content-center">
        <div class="services__content">
          <h3 class="fw-bold text-capitalize mt-1 position-relative">Personalized recommendations to help you learn better
          <div class="think-testimonial-underline">
            <img src="courselist/images/Under-line.png" alt="marketing illustration" class="img-fluid mx-auto d-block">
          </div>
          </h3>
          <p class="lh-lg my-5">
          I signed up for the Fundamentals of Quality Analysis course without having any prior knowledge in the field, but by the time I completed the course, I became proficient in functional QA & got a job in the field! The instructor did a wonderful job at teaching the subjects in a simple way!
          </p>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-5 text-start">
        <div class="services__pic text-end">
          <img src="courselist/images/personalized_engine_avatar.svg" alt="web development illustration" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- Our courses -->
  @php
  use App\Http\Controllers\Student\CoursesCatalogController;
  use App\Models\Notification;
  $courses = CoursesCatalogController::getAllCourses();
  
  $user = Auth::user();

  if($user) {
    $notifications = Notification::where('user', $user->id)->orderBy('created_at', 'DESC')->get();
  }
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
            @endif
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                  <x-Courseboxsmall :course="$course" />
                </div>
                @if(($loop->iteration % 3 == 0) && (!$loop->last))
                  </div>
                </div>
                <div class="carousel-item">
              <div class="row">
                @endif
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
            <x-nodatafound message="No courses to be shown!"  notype="" />
          </div>

        </div>
        @endif
      </div>
    </div>
    <div class="row mt-3 mb-4 text-center">
      <div class="col-md-12">
        <a href="{{ route('student.courses.get') }}" class="btn think-btn-secondary-outline" type="button">Explore all Courses</a>
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
          </div>
      </h1>

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
          <label class="think-testimonial-writer d-block text-center">YANA SIZIKOVA</label>
          <span class="d-block text-center">Software Engineer, Canada</span>
          <div class="text-end"><i class="fas fa-quote-right fa-3x ms-0"></i></div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="my-5">
  <hr class="hr-line">
</div>
<section class="mb-5">
  <div class="container">
    <div class="row pt-2 pb-2 mt-0 mb-3 justify-content-center text-center">
      <div class="dotted-decoaration"><img src="/storage/icons/dotted.svg" alt="error"></div>
      <div class="col-md-11">
        <div class="think-yellow-container bg-warning rounded-3">
          <h2 class="fw-bold text-center text-white mb-4">
            Have a question?
          </h2>
          <button class="btn think-btn-secondary-outline border-0" type="button" data-bs-toggle="modal" data-bs-target="#contactModal">CONTACT US</button>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection('content')

@push('child-scripts')
<script>
  let counterFlag = 0;
  let courseCounter = 0;
  let studentCounter = 0;

  window.addEventListener("scroll", () => {
    let counterTop = document.getElementById('portfolio').getBoundingClientRect().top;
    if (counterTop <= 1000 && counterFlag == 0) {
      let interval = setInterval(function(event) {
        counterFlag = 1;
        studentCounter++;
        courseCounter += 10;
        if (courseCounter <= 1000) {
          document.getElementById('student_count').innerHTML = courseCounter + "+";
        }
        if (studentCounter <= 50) {
          document.getElementById('course_count').innerHTML = studentCounter + "+";
        }
      }, 100)
    }
  });
</script>
<script>
  window.onload = function(e) {
    var url = window.location.href;

    let parameter = url.substr(url.indexOf('?'), url.length);
    if (parameter == "?redirect=true") {
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
  window.onload = (event)=> {
  var toastLiveExample = document.getElementById('liveToast');
  if(toastLiveExample) {
    var toast = new bootstrap.Toast(toastLiveExample);
    toast.show();
  }
  
  }
</script>
@endpush
