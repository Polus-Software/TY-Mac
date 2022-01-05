
@extends('Layouts.enrollCourse')
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 d-flex me-auto">
      @csrf
        <input id="search-box" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width:30rem !important;">
        <button class="btn btn-outline-success" id="search-btn">Search</button>
      </form>

      <ul class="navbar-nav">
      @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="#">Welcome, {{Auth::user()->firstname}}</a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('student.courses.get') }}">All Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Apply to be an instructor?</a>
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
          <a class="nav-link" href="{{ route('signup') }}">Signup</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        @endif
      </ul>
      
    </div>
  </div>
</nav>
<header class="d-flex align-items-center mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-1 mb-3 mt-4">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <img src="{{asset('/storage/courseThumbnailImages/'.$courseDetails['course_thumbnail_image'])}}" class="img-fluid col-md-12 col-sm-12 col-12 card-image h-100" alt="coursepicture">
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card-body">
                                <h5 class="card-title pb-3">
                                    {{$courseDetails['course_title']}}
                                </h5>
                                <p class="card-text"> {{$courseDetails['description']}}</p>
                                <div class="row">
                                    <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i><small>(60 ratings) 100 participants</small>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                            <p><i class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                {{$courseDetails['course_category']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                            <p><i class="far fa-user pe-1"></i>
                                                {{$courseDetails['instructor_firstname']}} {{$courseDetails['instructor_lastname']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                            <p><i class="far fa-user pe-1"></i>        
                                                {{$courseDetails['course_difficulty']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                            <p><i class="far fa-clock pe-1"></i>duration</p>
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
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="border-bottom pb-3">Choose Your Cohort</h1>
        </div>
    </div>
    <div class="row">
        @foreach($singleCourseDetails as $singleCourseDetail)
        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-4">
            <div class="card-2 text-center" style="width: auto;">
               <input type="hidden" id="batch_id" value="{{$singleCourseDetail['batch_id']}}">
                    <div class="card-body">
                        <i class="far fa-calendar-alt pb-3"></i>
                        <p class="card-text-1">Cohort starts - {{$singleCourseDetail['start_date']}}</p>
                        <p class="card-text-1">{{$singleCourseDetail['batchname']}}</p>
                        <p class="card-text">
                            {{$singleCourseDetail['start_time']}} {{$singleCourseDetail['region']}} - {{$singleCourseDetail['end_time']}}
                            {{$singleCourseDetail['region']}}
                        </p>
                    
                    </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row mt-4">
        <div class="form-group buttons d-flex justify-content-end">
            @csrf
            <button type="submit" id="registerNowButton" class="btn">Register Now</button>
            <input type="hidden" id="course_id" value="{{$courseDetails['course_id']}}">
        </div>
    </div>
</div>
</section>

<script>
    document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});

    let cards = document.getElementsByClassName('card-2');
    for(var index = 0; index < cards.length; index++) {
        cards[index].addEventListener('click', function (event){
            this.classList.add("active-batch");
            for(var index = 0; index < cards.length; index++) {
                if (cards[index]!=this) {
                    console.log(cards[index]);
                    cards[index].classList.remove("active-batch");
                }
            }
    });
}

document.getElementById('registerNowButton').addEventListener('click', (event) => {

     let courseId = document.getElementById('course_id').value;
     let activeBatch = document.getElementsByClassName('active-batch')[0].children[0];
     let batchId = activeBatch.value;
     let path = "{{ route('student.course.register.post') }}?course_id=" + courseId + '&batch_id=' + batchId;
     
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
               window.location.href ="/enrolled-course?course_id="+ courseId;
            }
            
        });
});

</script>
@endsection('content')