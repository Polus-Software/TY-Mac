@extends('Layouts.app')
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

<header class="ty-mac-header-bg d-flex align-items-center mt-3">
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-6 col-md-12 order-2 order-lg-1 p-3 pt-4">

        <div class="text-content-wrapper w-100 text-lg-start">
          <p class="mb-2">@foreach($singleCourseDetails as $singleCourseDetail)
            {{$singleCourseDetail['course_title']}}
            @endforeach
          </p>
        </div>
        <div class="row row-1">
          <div class="col-auto">
            <p class="border-end pe-4"><i class="far fa-clock"></i>@foreach($singleCourseDetails as $singleCourseDetail)
              {{$singleCourseDetail['duration']}}
              @endforeach
            </p>
          </div>
          <div class="col-auto">
            <p class="border-end pe-4"><img class="me-1" src="/storage/icons/level__icon.svg" alt="error">@foreach($singleCourseDetails as $singleCourseDetail)
              {{$singleCourseDetail['course_difficulty']}}
              @endforeach
            </p>
          </div>
          <div class="col-auto p-0">
            <p class="ms-2">@foreach($singleCourseDetails as $singleCourseDetail)
              <img class="me-1 think-w-14_5" src="/storage/icons/category__icon.svg" alt="error"> {{$singleCourseDetail['course_category']}}
              @endforeach
            </p>
          </div>
        </div>
        <div class="row row-2 mb-2">
          <div class="col-lg-12">
            <p class="para-1 mb-2">What You'll Learn</p>
            @foreach($short_description as $value)
            <p class="para-2 mb-1"><img class="me-2" src="/storage/icons/tick__icon.svg" alt="error">{{$value}} <br>
              @endforeach
            </p>

          </div>
        </div>
        <div class="row row-3 pt-2">
          <div class="col-auto">
            <p class="">Instructed by <strong class="text-capitalize">
                @foreach($singleCourseDetails as $singleCourseDetail)
                {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                @endforeach
              </strong></p>
          </div>
          <div class="col-auto">|</div>
          <div class="col-auto">
            <p>Upcoming Cohort: <strong>11/10/2021</strong></p>
          </div>
        </div>

        <div class="row align-items-center mt-2">
          @unless($userType == 'admin' || $userType == 'instructor' || $userType == 'content-creator')
          @if($enrolledFlag == false)
          <div class="col-md-auto">
            <a class="btn think-btn-tertiary think-h-48" id="enrollButton">
              Enroll now
            </a>
            <input type="hidden" id="course_id" value="{{$singleCourseDetail['id']}}">
            <input type="hidden" id="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
          </div>
          @else
          <div class="col-md-auto">
            <h6 class="m-0 think-color-primary">Already enrolled!</h6>
          </div>
          @endif
          <div class="col-md-auto"><a class="btn think-btn-tertiary-outline think-h-48" type="button" data-bs-toggle="modal" data-bs-target="#contactModal"><span>Have a question?</span></a></div>
          @endunless
        </div>
        <div class="row mt-2">
          @foreach($singleCourseDetails as $singleCourseDetail)
          <div class="col-lg-12">
            <span class="fw-bold">share this course: </span>
            <a class="btn" target="_blank" href="http://www.facebook.com/sharer.php?s=100&p[title]= <?php echo urlencode($singleCourseDetail['course_title']); ?>&amp;p[summary]=<?php echo urlencode($singleCourseDetail['description']) ?>&amp;p[url]=<?php echo urlencode(url('/')); ?>&amp;p[images][0]=<?php echo urlencode('/storage/courseImages/' . $singleCourseDetail['course_image']); ?>">
              <i class="fab fa-facebook fa-lg btn-dark me-3"></i></a>
          </div>
          @endforeach
        </div>
      </div>

      <div class="col-lg-6 col-md-12 order-1 order-lg-2">
        <img src="{{asset('/storage/courseImages/'.$singleCourseDetail['course_image'])}}" alt="course-image" class="img-fluid course-picture" style="height: auto;">
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
        <div class="card">
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
      <div class="col-lg-8 d-flex flex-column">
        <div class="card card-2 mb-3 flex-grow-1">
          <div class="card-body">
            <h5 class="card-title border-bottom pb-3 pt-2">Course Content</h5>
            @php ($slno = 0)
            @foreach($courseContents as $courseContent)
            @php ($slno = $slno + 1)
            <h6 class="card-subtitle mt-3"> Session {{$slno}} - {{$courseContent['topic_title']}}</h6>
            <ul class="list-group list-group-flush border-bottom pb-3 mt-3">
              @foreach($courseContent['contentsData'] as $content)
              <li class="ms-3 border-0 pb-2" style="list-style:circle;" id="{{$content['topic_content_id']}}">{{$content['topic_title']}}</li>
              @endforeach
            </ul>
            @endforeach
          </div>
        </div>
        <!-- course content end-->
        <!-- Who is this course is for -->
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-body p-4">
              <h5 class="card-title">Who is this course for?</h5>
              <p class="card-text-1">@foreach($singleCourseDetails as $singleCourseDetail)
                {{$singleCourseDetail['course_details']}}
              </p>
              @endforeach
              @foreach($course_details_points as $course_details_point)
              @if($course_details_point != '')
              <p class="card-text-1 mb-2"><img class="me-2" src="/storage/icons/tick__icon.svg" alt="error">{{$course_details_point}} </p>
              @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <!-- instructor profile -->
      <div class="col-lg-4 d-flex flex-column">
        <div class="card card-3 mb-3">
          <div class="row g-0 border-bottom" style=" background:#F8F7FC; border-radius:10px 10px 0px 0px;">
            <div class="col-sm-auto col-12">
              @foreach($singleCourseDetails as $singleCourseDetail)
              <img src="{{ asset('/storage/images/'.$singleCourseDetail['profile_photo']) }}" class="img-fluid rounded-circle m-2 p-2 d-flex align-items-center" alt="..." style="width:94px; height:94px;">
              @endforeach
            </div>
            <div class="col-sm col-12">
              <div class="card-body ps-2">
                <h5 class="card-title pt-2">
                  @foreach($singleCourseDetails as $singleCourseDetail)
                  {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                  @endforeach
                </h5>
                <p class="card-text-1">
                  @foreach($singleCourseDetails as $singleCourseDetail)
                  {{$singleCourseDetail['designation']}} at {{$singleCourseDetail['institute']}}
                </p>
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

            <div class="row d-flex justify-content-center mb-4">
              <div class="col-auto">
                <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                       {{$singleCourseDetail['instructorTwitter']}}
                                        @endforeach" target="_blank">
                  <img class="me-2" src="/storage/icons/twitter__icon.svg" alt="error">
                </a>
              </div>
              <div class="col-auto">
                <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorLinkedin']}}
                                            @endforeach" target="_blank">
                  <img class="me-2" src="/storage/icons/linkedin__icon.svg" alt="error">
                </a>
              </div>
              <div class="col-auto">
                <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                            {{$singleCourseDetail['instructorYoutube']}}
                                            @endforeach" target="_blank">
                  <img class="me-2" src="/storage/icons/youtube__icon.svg" alt="error">
                </a>
              </div>
            </div>

          </div>

        </div>
        <!-- instructor profile end -->
        <!-- live cohorts -->
        <div class="card card-4 mb-3 mt-3 flex-grow-1" style="background: #F8F7FC;">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">Upcoming Live Cohorts</h5>


            @if(count($liveSessions))
            @foreach($liveSessions as $liveSession)
            <div class="row g-0 border-bottom">
              <div class="col-auto">
                <img src="/courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block py-2" alt="error">
              </div>
              <div class="col">
                <div class="card-body">
                  <h5 class="card-title">
                    <a style="text-decoration:none;color:#2C3443;">{{$liveSession['session_title']}}</a>
                  </h5>
                  <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                </div>
              </div>
            </div>
            @endforeach
            @else
            <h6>No upcoming live cohorts!</h6>
            @endif
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
          <div class="card-body p-4">
            <h5 class="card-title">Student Reviews</h5>
            <div class="row">
              @if(!empty($singleCourseFeedbacks))
              @foreach($singleCourseFeedbacks as $singleCourseFeedback)
              <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                <img src="{{asset('/storage/images/'.$singleCourseFeedback['studentProfilePhoto'])}}" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                <div class="card-body">
                  <h5 class="card-title text-left">
                    {{$singleCourseFeedback['studentFirstname']}} {{$singleCourseFeedback['studentLastname']}}
                  </h5>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      @for($i = 1; $i<=5; $i++) @if($i <=$singleCourseFeedback['rating']) <i class="fas fa-star rateCourse"></i>
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
              @else
              <h6 class="mt-4" style="text-align:center;">No reviews yet.</h6>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- student reviews end-->
@endsection('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('/assets/singlecourse.css') }}">
@endpush
@push('child-scripts')
<script>
  document.getElementById('enrollButton').addEventListener('click', (e) => {
    e.preventDefault();
    let path = "{{ route('student.course.enroll') }}";
    fetch(path, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },

    }).then((response) => response.json()).then((data) => {
      if (data.status == 'success') {
        let courseId = document.getElementById('course_id').value;
        window.location.href = "/register-course?id=" + courseId;

      } else {
        let loginModal = new bootstrap.Modal(
          document.getElementById("loginModal"), {});
        loginModal.show();
      }
    });
  });


  let finalRating = 0;

  let stars = document.getElementsByClassName('rating-star');
  for (var index = 0; index < stars.length; index++) {
    stars[index].addEventListener('click', function(event) {
      let starRating = parseInt(this.getAttribute('star-rating'));

      for (var i = 0; i < starRating; i++) {
        stars[i].classList.add("active-stars");
      }
      for (var i = starRating; i < index; i++) {
        console.log(i);
        stars[i].classList.remove("active-stars");
      }
      finalRating = starRating;
    });
  }


  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }
</script>
<script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
@endpush