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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 d-flex me-auto">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width:30rem !important;">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
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







<header class="d-flex align-items-center mb-3">
    <div class="container">
        <div class="row">
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
                                            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                                <p class="duration"><i class="far fa-clock pe-1"></i>
                                                    Next Live Class: - <small>11/19/2021 - 9 AM IST - 10 AM IST</small>
                                                </p>
                                                
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
        <div class="container">
            <div class="row">
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
                                    <div class="badge-shadow left-0"><img src="Badges/Badge 1.svg" alt=""></div>
                                    <div class="badge-shadow left--15"><img src="Badges/Badge 2.svg" alt=""></div>
                                    <div class="badge-shadow left--30"><img src="Badges/Badge 3.svg" alt=""></div>
                                    <!-- <div class="badge-shadow left--45"><img src="Badges/More.svg" alt=""></div> -->
                                        <button class="nav-link bg-transparent left--45 p-0" id="v-pills-achievements-tab" data-bs-toggle="pill" data-bs-target="#v-pills-achievements" type="button" role="tab" aria-controls="v-pills-achievements" aria-selected="false">
                                           <img src="Badges/More.svg" alt="">
                                        </button>
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
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h6 class="card-title pt-2">Session 1 - Intro to G Suite & Google Drive</h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end">
                                            <button type="button" class="btn"><i class="fas fa-undo pe-2"></i>View again</button>
                                        </div>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush border-bottom pb-3">
                                        <li class="list-group-item">
                                            <ul>
                                                <li>How to use Google Suite</li>
                                                <li>How to use Google Drive</li>
                                                <li>Creating a folder in Google Drive</li>
                                                <li>Sharing a folder in Google Drive</li>
                                            </ul>
                                        </li>
                                    </ul>   

                                    <div class="row">
                                        <div class="col-lg-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h6 class="card-title pt-3">Session 1 - Intro to G Suite & Google Drive</h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end">
                                            <button type="button" class="btn go-live"><i class="fas fa-eye pe-2"></i>Go to live</button>
                                        </div>
                                    </div>
                                
                                    <ul class="list-group list-group-flush border-bottom pb-3">
                                        <li class="list-group-item">
                                            <ul>
                                                <li>How to use Google Suite</li>
                                                <li>How to use Google Drive</li>
                                                <li>Creating a folder in Google Drive</li>
                                                <li>Sharing a folder in Google Drive</li>
                                            </ul>
                                        </li>
                                    </ul>   

                                    <div class="row">
                                        <div class="col-lg-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h6 class="card-title pt-3">Session 1 - Intro to G Suite & Google Drive</h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end">
                                            <p><i class="far fa-clock pe-1 pt-3"></i>Next cohort: 11/19/2021 - 9 AM IST - 10 AM IST</button></p>
                                        </div>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush border-bottom pb-3">
                                        <li class="list-group-item">
                                            <ul>
                                                <li>How to use Google Suite</li>
                                                <li>How to use Google Drive</li>
                                                <li>Creating a folder in Google Drive</li>
                                                <li>Sharing a folder in Google Drive</li>
                                            </ul>
                                        </li>
                                    </ul> 

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                            <h6 class="card-title pt-3">Session 1 - Intro to G Suite & Google Drive</h6>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 col-12 d-flex justify-content-lg-end justify-content-md-end">
                                            <p><i class="far fa-clock pe-1 pt-3"></i>Next cohort: 11/19/2021 - 9 AM IST - 10 AM IST</button></p>
                                        </div>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush border-bottom pb-3">
                                        <li class="list-group-item">
                                            <ul>
                                                <li>How to use Google Suite</li>
                                                <li>How to use Google Drive</li>
                                                <li>Creating a folder in Google Drive</li>
                                                <li>Sharing a folder in Google Drive</li>
                                            </ul>
                                        </li>
                                    </ul> 
                                    
                                </div>
                            </div>

                            <div class="row border-bottom">
                                <div class="col-lg-12">
                                    <h5 class="recommendation">Recommended Topics to Review</h5>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                                <div class="col-lg-6 mb-3">
                                    <div class="card card-3" style="height: 560px;">
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
                                                          This is some text within a card body.
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <!-- <div class="card card-5">
                                                        <div class="card-body"> -->
                                                            <h6 class="card-title">Session 1 - Intro to G Suite & Google Drive</h6>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">
                                                                    <ul>
                                                                        <li>How to use Google Suite</li>
                                                                        <li>How to use Google Drive</li>
                                                                    </ul>
                                                                </li>
                                                            </ul>   
                                                        <!-- </div> -->
                                                    <!-- </div> -->
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
                                                          <p class="card-text">We recommend you to view again these topics.</p>
                                                        </div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <!-- <div class="card card-5">
                                                        <div class="card-body"> -->
                                                            <h6 class="card-title">Session 1 - Intro to G Suite & Google Drive</h5>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">
                                                                    <ul>
                                                                        <li>How to use Google Suite</li>
                                                                        <li>How to use Google Drive</li>
                                                                        <li>How to use Google Suite</li>
                                                                        <li>How to use Google Drive</li>
                                                                    </ul>
                                                                </li>
                                                            </ul>   
                                                        <!-- </div> -->
                                                    <!-- </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-personalizedRecommendations" role="tabpanel" aria-labelledby="v-pills-personalizedRecommendations-tab">
                        
                            <div class="row border-bottom">
                                <div class="col-lg-12">
                                    <h5 class="recommendation">Recommended Topics to Review</h5>
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
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">
                                                                    <ul>
                                                                        <li>How to use Google Suite</li>
                                                                        <li>How to use Google Drive</li>
                                                                    </ul>
                                                                </li>
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
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">
                                                                    <ul>
                                                                        <li>How to use Google Suite</li>
                                                                        <li>How to use Google Drive</li>
                                                                        <li>How to use Google Suite</li>
                                                                        <li>How to use Google Drive</li>
                                                                    </ul>
                                                                </li>
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
                                    <div class="card-body">
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
                       

                        <div class="tab-pane fade" id="v-pills-achievements" role="tabpanel" aria-labelledby="v-pills-achievements-tab">
                            <div class="card card-8 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title border-bottom pt-2 pb-2">Badges Earned</h5>
                                    
                                        <div class="row earned-badges pt-5 pb-5 d-flex justify-content-lg-center mb-3">
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Badge 1.svg" alt="">  
                                                <p class="col-lg-12 badges ps-2 m-0">Joinee</p>
                                                <small>November 11, 2021</small>
                                            </div>
                                        
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Badge 2.svg" alt=""> 
                                                <p class="col-lg-12 badges ps-2 m-0">Starter</p>
                                                <small>November 11, 2021</small>
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Badge 3.svg" alt="">
                                                <p class="col-lg-12 badges m-0">Assignment</p>
                                                <small>November 11, 2021</small> 
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Next.svg" alt=""> 
                                                <p class="col-lg-12 badges ps-3 m-0">Next</p>
                                                <small>November 11, 2021</small>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Next.svg" alt=""> 
                                                <p class="col-lg-12 badges ps-3 m-0">Next</p>
                                                <small>November 11, 2021</small>
                                            </div>
                                        </div>
                                     
                                        <h5 class="card-title border-bottom pt-2 pb-2">Upcoming Badges</h5>
                                        <div class="row pt-5 pb-5 d-flex justify-content-start ps-3">
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Badge.svg" alt="">  
                                                <p class="col-lg-12 badges m-0">Q&A</p>
                                                <small>-----</small>
                                            </div>
                                        
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="Badges/Completion.svg" alt=""> 
                                                <p class="col-lg-12 badges m-0">Completion</p>
                                                <small>---</small>
                                            </div>

                                        </div>

                                        <h5 class="card-title border-bottom pt-2 pb-2 mb-4">Badge List</h5>
                                        <div class="row d-flex justify-content-start ps-3 mb-3 mt-3">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                            <img src="Badges/Badge 1.svg" alt=""> 
                                                <p class="col-lg-12 badges m-0">Joinee</p>
                                                <small>---</small>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                <p>Joinee</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                            </div>  
                                        </div>
                                        <div class="row d-flex justify-content-start ps-3">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                            <img src="Badges/Badge 2.svg" alt=""> 
                                                <p class="col-lg-12 badges m-0">Starter</p>
                                                <small>---</small>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                <p>Joinee</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                            </div>  
                                        </div>

                                        <div class="row d-flex justify-content-start ps-3">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                            <img src="Badges/Badge 3.svg" alt=""> 
                                                <p class="col-lg-12 badges m-0">assignment</p>
                                                <small>---</small>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                <p>Joinee</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                            </div>  
                                        </div>
                                        <div class="row d-flex justify-content-start ps-3">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                            <img src="Badges/Badge.svg" alt=""> 
                                                <p class="col-lg-12 badges">Q&A</p>
                                                <small>---</small>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                <p>Joinee</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                            </div>  
                                        </div>

                                        <div class="row d-flex justify-content-start ps-3">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                            <img src="Badges/Completion.svg" alt=""> 
                                                <p class="col-lg-12 badges">Completion</p>
                                                <small>---</small>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                <p>Joinee</p>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                            </div>  
                                        </div>
                                            
                                            

                                           

                                        </div>
                                </div>
                            </div>
                        </div>

                        

                        



























                    </div>
                </div>
            </div>
    </section>




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