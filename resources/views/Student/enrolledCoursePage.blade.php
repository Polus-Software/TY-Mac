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

.card-title-certificate{
    padding-bottom:35px;
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 900;
    margin-top:55px;
    
}
.accordion-button:not(.collapsed) {
    color: #6E7687 !important;
    background-color: transparent !important;
}


.card-title-1-certificate{
    color:#F5BC29;
    text-align: center;
    padding-bottom: 40px;
    padding-top:20px;
    font-family: 'Roboto', sans-serif;
    font-weight: 900;
    font-size:28px;
   
}
.card-text-1-certificate{
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 400; 
    color: #6E7687;
}
.card-text-2-certificate{
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 900; 
    border-bottom:1px solid #F5BC29;
    padding-bottom:30px;
    font-size:28px;
}
.signature-img{
    display: block;
    margin: 0 auto;
    /* border-bottom:1px solid #F5BC29; */
    
}
.signature{
    border-bottom:1px solid #F5BC29;
    padding-bottom:30px;
}
  </style>
<header class="d-flex align-items-center mb-3 mt-4">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card card-1  border-0 mb-3 mt-4 mw-100">
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
                                <p class="card-text position-relative">
                                    <span class="think-truncated-text">
                                    @foreach($singleCourseDetails as $course)
                                    {{Str::limit($course['description'], 180, '...')}}
                                    @endforeach
                                    </span>
                                </p>
                                <div class="row">
                                    <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                        <div class="progress rounded-pill">
                                            <div class="progress-bar rounded-pill text-end pe-2" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                        <p class="para-1"><img class="me-1" src="/storage/icons/category__icon.svg" alt="error">
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
                                        <p class="para-2">
                                            <img class="me-1" src="/storage/icons/level__icon.svg" alt="Difficulty level">
                                            @foreach($singleCourseDetails as $course)
                                            {{ $course['course_difficulty'] }}
                                            @endforeach

                                        </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                            <p class="duration"><i class="far fa-clock pe-1"></i>
                                                Next Live Class: - <small>{{$next_live_cohort}}</small>

                                            </p>
                                            @foreach($singleCourseDetails as $course)
                                            <!-- <a href="{{ route('generate-certificate', $course['id']) }}" class="btn p-0 mb-3">Download certificate<i class="fas fa-download ps-3"></i></a> -->
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                                                <!-- <p class="duration"><i class="far fa-clock pe-1"></i>
                                                    Next Live Class: - <small>{{$next_live_cohort}}</small>
                                                   
                                                </p> -->
                                               
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6 text-end">
                                            @if($userType == 'student')
                                                <a class="btn btn-dark" id="reviewButton" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                                Add review
                                            </a>
                                            @endif
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
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12 col-12 vertcalNav mb-3">
                <div class="row sidebar pt-4">
                    <h3 class="text-center">Cohort Details</h3>
                    <div class="nav flex-column nav-pills d-flex align-items-start pe-0 pt-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if($userType == 'instructor')
                        <button class="nav-link mb-2 ps-5 text-start active" id="v-pills-cohortOverview-tab" data-bs-toggle="pill" data-bs-target="#cohort-overview" type="button" role="tab" aria-controls="v-pills-cohortSchedule" aria-selected="true">
                            <i class="fas fa-chart-bar pe-3"></i>Cohort Overview
                        </button>
                        @endif
                        <button class="nav-link {{($userType == 'student') ? 'active' : ''}} mb-2 ps-5 text-start" id="v-pills-cohortSchedule-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cohortSchedule" type="button" role="tab" aria-controls="v-pills-cohortSchedule" aria-selected="true">
                            <i class="far fa-clock pe-3"></i>Cohort Schedule
                        </button>
                        <button class="nav-link mb-2 ps-5 text-start" id="v-pills-personalizedRecommondations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-personalizedRecommendations" type="button" role="tab" aria-controls="v-pills-CohortQuestions" aria-selected="false">
                        <i class="fas fa-tv pe-3"></i>Personalized recommendations
                        </button>
                        <button class="nav-link mb-2 ps-5 text-start" id="v-pills-CohortQuestions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-CohortQuestions" type="button" role="tab" aria-controls="v-pills-CohortQuestions" aria-selected="false">
                        <i class="fas fa-comments pe-3"></i>Cohort Q&A
                        </button>
                        <button class="nav-link mb-2 ps-5 text-start" id="v-pills-cohortInfo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cohortInfo" type="button" role="tab" aria-controls="v-pills-cohortInfo" aria-selected="false">
                        <i class="fas fa-info-circle pe-3"></i>Cohort Info
                        </button>
                        <button class="nav-link mb-2 ps-5 text-start" id="v-pills-assignments-tab" data-bs-toggle="pill" data-bs-target="#v-pills-assignments" type="button" role="tab" aria-controls="v-pills-assignments" aria-selected="false">
                        <i class="fas fa-newspaper pe-3"></i>Assignments
                        </button>
                        @if($userType == 'student')
                        <button class="nav-link mb-2 ps-5 text-start" id="v-pills-certificate-tab" data-bs-toggle="pill" data-bs-target="#v-pills-certificate" type="button" role="tab" aria-controls="v-pills-certificate" aria-selected="false">
                        <img src="/storage/icons/Icon awesome-trophy.svg" alt="error" class="pe-2">Completion Certificate
                    </button>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 border-bottom mt-3 mb-3"></div>
                        <p class="ps-5 text-start align-items-start achievement">ACHIEVEMENTS</p>

                        <div class="container d-flex">
                            <div class="badge-shadow left-0"><img src="/Badges/Badge 1.svg" alt=""></div>
                            <div class="badge-shadow left--15"><img src="/Badges/Badge 2.svg" alt=""></div>
                            <div class="badge-shadow left--30"><img src="/Badges/Badge 3.svg" alt=""></div>
                            <div class="badge-shadow left--45">
                                <button class="nav-link bg-transparent p-0" id="v-pills-achievements-tab" data-bs-toggle="pill" data-bs-target="#v-pills-achievements" type="button" role="tab" aria-controls="v-pills-achievements" aria-selected="false">
                                    <img src="/Badges/More.svg" alt="">
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-sm-12 col-12 gx-5">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- overview tab -->
                    @if($userType == 'instructor')
                    <div class="tab-pane fade show {{($userType == 'instructor') ? 'active' : ''}}" id="cohort-overview" role="tabpanel" aria-labelledby="cohort-overview">
                        <div class="row mb-5">
                            <div class="col-sm-3">
                                <div class="card llp-countbox">
                                    <div class="card-body text-center">
                                        <h1 class="card-title">18</h1>
                                        <p class="card-text">Hours spent</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card llp-countbox">
                                    <div class="card-body text-center">
                                        <h1 class="card-title">700</h1>
                                        <p class="card-text">Students joined</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card llp-countbox">
                                    <div class="card-body text-center">
                                        <h1 class="card-title">08</h1>
                                        <p class="card-text">Likes</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card llp-countbox">
                                    <div class="card-body text-center">
                                        <h1 class="card-title">180</h1>
                                        <p class="card-text">Dislikes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div id="chart_div" style="height: 500px;"></div>
                            </div>
                        </div>

                        <div class="row border-bottom">
                            <div class="col-lg-12">
                                <h5 class="recommendation">Recommended Topics to Review</h5>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table llp-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Session name</th>
                                        <th scope="col">Subtopic</th>
                                        <th scope="col">Likes</th>
                                        <th scope="col">Dislikes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($graph as $data)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>Session - {{ $data['topic_title'] }}</td>
                                        <td>{{ $data['topic_title'] }}</td>
                                        <td>{{ $data['likes'] }}</td>
                                        <td>{{ $data['dislikes'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    @endif
                    <!-- overview tab -->
                    <!-- schedule tab -->
                    <div class="tab-pane fade show {{($userType == 'student') ? 'active' : ''}}" id="v-pills-cohortSchedule" role="tabpanel" aria-labelledby="v-pills-cohortSchedule">
                        <div class="card card-2 mb-3">
                            <div class="card-body">
                                <h5 class="card-title border-bottom pt-2 pb-2">Session info</h5>
                                @foreach($topicDetails as $topicDetail)
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <h6 class="card-title pt-2" data-id="{{ $topicDetail['topic_id'] }}">{{ $topicDetail['topic_title'] }}</h6>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end mt-2">
                                        @if($topicDetail['liveId'] == null)
                                        @if(!empty($liveSessions))
                                        <span>Next Live Class:{{ $topicDetail['startDate'] }} - {{ $topicDetail['startTime'] }} {{ $topicDetail['time_zone'] }} - {{ $topicDetail['endTime'] }} {{ $topicDetail['time_zone'] }}</span>
                                        @else
                                        <span>No sessions scheduled</span>
                                        @endif
                                        @elseif($topicDetail['liveId'] == "Over")
                                        <a style="background-color: #f0f0f0;color: black;" type="button" class="btn" href=""><i class="fas fa-undo pe-2"></i>View again</a>
                                        @else
                                        <a style="background-color: #74648C;color: white;" type="button" class="btn" href="/session-view/{{ $topicDetail['liveId'] }}"><i class="fas fa-eye pe-2"></i>View live session</a>
                                        @endif
                                    </div>
                                </div>
                                @if($loop->count == $loop->iteration)
                                <ul class="list-group list-group-flush pb-3">
                                @else
                                <ul class="list-group list-group-flush border-bottom pb-3">
                                @endif
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
                            @forelse($recommendations as $recommendation)
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
                            @empty
                             <x-nodatafound message="No recommendations for you yet!" />
                            @endforelse
                        </div>

                    </div>
                    <!-- schedule tab -->
                    <!-- Recommendations tab -->
                    <div class="tab-pane fade" id="v-pills-personalizedRecommendations" role="tabpanel" aria-labelledby="v-pills-personalizedRecommendations-tab">

                        <div class="row border-bottom">
                            <div class="col-lg-12">
                                <h5 class="heading-1">{{($userType == 'student') ? 'Recommended Topics to Review' : 'Personalized Recommendations'}}</h5>
                            </div>
                        </div>
                        @if($userType == 'student')
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
                        @endif
                        @if($userType == 'instructor')

                        <div class="row mt-3 mb-3">
                            <div class="accordion" id="accordionExample">
                                @foreach($studentsEnrolled as $student)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{ $student->id }}" aria-expanded="true" aria-controls="collapseOne_{{ $student->id }}">
                                        <i class="fas fa-user-circle pe-3"></i>{{ $student->firstname .' '. $student->lastname }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne_{{ $student->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row mt-3 mb-3">
                                                @foreach($recommendations as $recommendation)
                                                @if($recommendation['student_id'] == $student->user_id)
                                                <div class="col-lg-6 mb-3">
                                                    <div class="card card-3" style="height: 550px;">
                                                        <img src="/courselist/Illustration/Mask Group 2.jpg" class="card-img-top img-fluid" alt="...">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <a href="#" class="btn btn-primary w-100">1-on-1 Session</a>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-lg-12">
                                                                    <div class="card card-4">
                                                                        <div class="card-body">
                                                                            The student did not understand this topic. We recommended the student to view this topic again.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="card card-5">
                                                                        <div class="card-body">
                                                                            <h6 class="card-title">Session 1 - {{ $recommendation['topic_title'] }}</h6>
                                                                            <ul class="list-group list-group-flush pb-3">
                                                                                <li class=" ms-4 border-0 pb-2">{{ $recommendation['content_title'] }}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>@endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- Recommendations tab -->

                    <div class="tab-pane fade" id="v-pills-CohortQuestions" role="tabpanel" aria-labelledby="v-pills-CohortQuestions-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-6">
                                    <div class="card-body">
                                        <div class="row border-bottom">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                <h5 class="card-title">Questions & Answers</h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-end mb-3">
                                                @if($userType == "student")
                                                <button id="ask_a_question" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#questionModal">Ask a question</button>
                                                @endif
                                            </div>

                                        </div>
                                       
                                                                                        
                                        <div class="row">

                                        @foreach($qas as $qa)
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                            @foreach($singleCourseDetails as $course)
                                                <img src="{{ asset('/storage/images/'.$qa['student_profile_photo']) }}" class="img-fluid rounded-circle mt-3" alt="..." style="width:40px; height:40px;">
                                                @endforeach
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <p class="card-title text-left">
                                                            {{ $qa['student'] }}
                                                        </p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <p class="text-end time">{{ $qa['date'] }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <p class="para-1">{{ $qa['question'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if($userType == "instructor" && !$qa['hasReplied'])
                                                    <div class="row" id="replyTextArea_{{ $qa['id'] }}">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                            @csrf
                                                            <textarea id="reply_{{ $qa['id'] }}" class="form-control" placeholder="Type your reply.."></textarea>
                                                            <button data-id="{{ $qa['id'] }}" style="float:right;" class="btn btn-dark replyBtn mt-2">Reply</button>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($qa['hasReplied'])
                                            <div class="row ps-5">
                                            @else
                                            <div class="row ps-5" id="replyDiv_{{ $qa['id'] }}" style="display:none">
                                            @endif
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-center ps-5 pe-0">
                                                    @foreach($singleCourseDetails as $course)
                                                    <img src="{{asset('/storage/images/'.$course['profile_photo'])}}" class="img-fluid rounded-circle mt-3" alt="..." style="width:40px; height:40px;">
                                                    @endforeach
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                                <p class="card-title text-left">
                                                                    @foreach($singleCourseDetails as $course)
                                                                    {{ $course['instructor_firstname'] }} {{ $course['instructor_lastname'] }} &nbsp;{{ $course['designation'] }} at {{ $course['institute'] }}
                                                                    @endforeach

                                                                </p>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 pe-0">
                                                                <p class="text-end time" id="updatedAt_{{ $qa['id'] }}">{{ $qa['date'] }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <p class="para-1" id="replyContent_{{ $qa['id'] }}">{{ $qa['reply'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                            
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
                        @if($userType == 'student')
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card card-8 mb-5">
                                    <div class="row g-0 border-bottom" style=" background:#F8F7FC; border-radius:10px 10px 0px 0px;">
                                        <div class="col-lg-2 col-sm-4 col-4">
                                            @foreach($singleCourseDetails as $course)
                                            <img src="{{asset('/storage/images/'.$course['profile_photo'])}}" class="img-fluid rounded-circle m-2 p-2 d-flex align-items-center" alt="..." style="width:94px; height:94px;">
                                            @endforeach


                                        </div>
                                        <div class="col-lg-8 col-sm-8 col-8">
                                            <div class="card-body">
                                                <h5 class="instructor-name pt-2">
                                                    @foreach($singleCourseDetails as $course)
                                                    {{ $course['instructor_firstname'] }} {{ $course['instructor_lastname'] }}
                                                    @endforeach
                                                </h5>
                                                <p class="card-text-1">
                                                    @foreach($singleCourseDetails as $course)
                                                    {{ $course['designation'] }} at {{ $course['institute'] }}
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="card-text-1 p-3">
                                                @foreach($singleCourseDetails as $course)
                                                {{ $course['instructorDescription'] }}
                                                @endforeach
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <p><a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorTwitter']}}
                                            @endforeach" target="_blank"><i class="fab fa-twitter pe-2"></i></a>
                                                <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorLinkedin']}}
                                            @endforeach" target="_blank"><i class="fab fa-linkedin-in pe-2"></i></a>
                                                <a href="@foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['instructorYoutube']}}
                                            @endforeach" target="_blank"><i class="fab fa-youtube"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree_{{$slno}}" aria-expanded="false" aria-controls="collapseThree">
                                                Session {{$slno}} - {{$topicDetail['topic_title']}}
                                                @if($topicDetail['isAssignmentSubmitted'] == true)
                                                <span style="position:absolute;left:45rem;background-color:#b8ffb0 !important;width:6rem;" class="badge pill text-dark">Submitted</span>
                                                @else
                                                <span style="position:absolute;left:45rem;background-color:#faffb0 !important;color:#be5a21 !important;width:6rem;" class="badge pill text-dark">Pending</span>
                                                @endif
                                                </button>
                                                </h2>
                                                <div id="collapseThree_{{$slno}}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                @foreach($topicDetail['assignmentList'] as $assignment)
                                                <div class="col-12 mb-3">
                                                    <div class="card" id="card_{{ $topicDetail['topic_id'] }}" style="display:none;">
                                                    <div class="card-title p-3 bg-light border-bottom">
                                                        Assignment: {{$assignment['assignment_title']}}</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text">{{$assignment['assignment_description']}}</p>
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                            

                                                            <div class="col-lg-10">
                                                                <p style="color:#6E7687;" class="mt-4">External Link</p>
                                                                <a target="_blank" href="/assignmentAttachments/{{$assignment['document']}}">{{$assignment['document']}}</a></p>
                                                            <p></p>
                                                            </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-6">
                                                            <div class="row">
                                                            
                                                            </div>
                                                        </div>
                                                    
                                                    <div class="d-flex justify-content-center col-lg-12">

                                                    <div class="card mb-3" style="border: 2px dashed rgba(0,0,0,.125);border-radius: 1rem;">
    <div class="card-body">
        
        <div class="llpcard-inner bg-light mt-3 mb-3 p-3">
        <h5 class="card-title">Type your comment here</h5>
        <form action="{{ route('submit.assignment') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        @csrf
        <input type="hidden" name="assignment_id" value="{{ $assignment['id'] }}" />
        <textarea style="height: 110px;" class="form-control" type="text" name="assignment_comment" placeholder="Type your comment here.."></textarea>
                <div class="card card-body mb-3" style="background-color: transparent;background-clip: border-box;border: none;">
                    
                    <div class="row p-2 flex-fill bd-highlight">
                        <div class="col-lg-3">Attach File:</div>
                            <div class="col-lg-5 col-12"><label>Upload from device</label>
                                <input class="form-control" type="file" name="assignment_upload">
                            </div>
                        <!-- <div class="col-lg-3 pt-4"><a class="btn btn-sm btn-outline-secondary" style="height: 37px;line-height: 27px;">Add external link</a></div> -->
                        
                    </div>
                    <div class="col-12 text-end mt-4"><a class="btn btn-sm btn-outline-secondary me-3">Cancel</a><button type="submit" style="font-size: 14px;font-weight: 100;color: #ffffff;" class="btn btn-sm btn-dark">Submit</a>
                        </div>
</form>
                </div>
                    </div>
                    
                </div>
            <!-- </div> -->
        </div>
                                                    


                                                    </div>
                                                    </div>

                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 m-auto text-center">
                                                <a card-id="{{ $topicDetail['topic_id'] }}" class="btn btn-sm btn-dark me-3 start_assignment" href="">Start Assignment</a>
                                                </div>
                                                
                                            @endforeach
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <h6 class="card-title pt-2" id="{{$topicDetail['topic_id']}}"></h6>
                                        <ul class="list-group list-group-flush border-bottom pb-3 mt-3">
                                            
                                        </ul> -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($userType == 'student')
                        <div class="tab-pane fade" id="v-pills-achievements" role="tabpanel" aria-labelledby="v-pills-achievements-tab">
                            <div class="card card-8 mb-3">
                                <div class="card-body">
                                    <h5 class="card-title border-bottom pt-2 pb-2">Badges Earned</h5>
                                        <div class="row earned-badges pt-5 pb-5 d-flex mb-3">
                                        @if(!empty($achievedBadgeDetails))
                                        @foreach($achievedBadgeDetails as $achievedBadgeDetail)
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                                <img src="{{ asset('/storage/achievementBadges/'.$achievedBadgeDetail['badge_image']) }}" alt="badge" class="ms-3">  
                                                <p class="col-lg-12 badges ps-2 m-0"> {{$achievedBadgeDetail['badge_name']}}</p>
                                                <small> {{$achievedBadgeDetail['badge_created_at']}}</small>
                                            </div>
                                        @endforeach
                                        @else
                                        <h5 style="text-align:center;">No badges earned. Keep trying!</h5>
                                        @endif
                                        </div>

                                <h5 class="card-title border-bottom pt-2 pb-2">Upcoming Badges</h5>
                                <div class="row pt-5 pb-5 d-flex justify-content-start ps-3">
                                    @foreach($upcoming as $upcomingBadge)
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                        <img src="{{ asset('/storage/achievementBadges/'.$upcomingBadge['badge_image']) }}" alt="">
                                        <p class="col-lg-12 badges m-0">{{ $upcomingBadge['badge_name'] }}</p>
                                        
                                    </div>
                                    @endforeach
                                </div>

                                <h5 class="card-title border-bottom pt-2 pb-2 mb-4">Badge List</h5>
                                @foreach($badgesDetails as $badgesData)
                                <div class="row d-flex justify-content-start ps-3 mb-3 mt-3">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-4">
                                        <img src="{{ asset('/storage/achievementBadges/'.$badgesData['badge_image']) }}" alt="">
                                        <p class="col-lg-12 badges m-0 card-title">{{ $badgesData['badge_name'] }}</p>
                                        
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


                    <div class="tab-pane fade" id="v-pills-certificate" role="tabpanel" aria-labelledby="v-pills-certificate-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-2">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-8 col-sm-6 col-12 mb-4  border-bottom">
                                                <h5 class="card-title pt-2 pb-2">Completion Certificate</h5>
                                                </div>
                                                    <div class="col-lg-6 col-md-4 col-sm-6 col-12 mb-4 border-bottom">
                                                        <ul class="nav nav-pills justify-content-end mb-3" id="pills-tab" role="tablist">
                                                        <li class="nav-item" role="presentation" style="list-style:none;">
                                                            <button class="nav-link" id="pills-certificate-tab" data-bs-toggle="pill" data-bs-target="#pills-certificate" type="button" role="tab" aria-controls="pills-certificate" aria-selected="true">View Certificate</button>
                                                        </li>
                                                        </ul>
                                                    </div>
                                                    <div class="row">
                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade show active" id="pills-back" role="tabpanel" aria-labelledby="pills-back-tab">
                                                                No certificates
                                                            </div>
                                                            <div class="tab-pane fade" id="pills-certificate" role="tabpanel" aria-labelledby="pills-back-certificate">
                                                                <div class="col-lg-12 d-flex justify-content-center">
                                                                    <div class="card text-center" style="margin: auto; width: 100%;">
                                                                        <div class="card-body">
                                                                        <!-- <img src="/storage/icons/ty_mac__transparent__1000.png" alt="" class="img-fluid" style="width:180px; height:180px;"> -->
                                                                            <small style="position: absolute; left: 0px; top:20px; left:15px;">Thinklit</small>
                                                                            <small style="position: absolute; right: 35px; top:20px;">DATE OF ISSUE :  
                                                                            @foreach($singleCourseDetails as $course)
                                                                                {{ $course['date_of_issue'] }} 
                                                                            @endforeach</small>
                                                                            <small style="position: absolute; right: 45px; top:40px;"></small>
                                                                            <img src="/storage/icons/ty_mac__transparent__1000.png" alt="" class="img-fluid" style="width:180px; height:180px;">
                                                                            <!-- <h1 class="card-title-certificate" style="margin-top:20px;">ThinkLit</h1> -->
                                                                            <div style="background:#FFF9E8;">
                                                                            <h3 class="card-title-1-certificate">Certificate of completion</h3>
                                                                            <p class="card-text-2-certificate">@foreach($singleCourseDetails as $course)
                                                                                        {{ $course['student_firstname'] }} {{ $course['student_lastname'] }}
                                                                                        @endforeach</p>
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <p class="card-text-1">Has successfully completed the {{$course['course_title']}}  <br>
                                                                                    online cohort on (course completion date)</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                            @foreach($singleCourseDetails as $course)
                                                                            <img src="{{asset('/storage/signatures/'.$course['instructor_signature'])}}" alt="" class="img-fluid" 
                                                                            style="border-bottom:1px solid #F5BC29;"> 
                                                                            @endforeach
                                                                            </div>
                                                                            <div class="col-lg-12 mt-4">
                                                                                <p class="card-text-1">@foreach($singleCourseDetails as $course)
                                                                                    {{ $course['instructor_firstname'] }}  {{ $course['instructor_lastname'] }}
                                                                                        @endforeach
                                                                                </p>
                                                                                <p class="card-text-1">&<br>Team ThinkLit</p>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                @foreach($singleCourseDetails as $course)
                                                                        <a href="{{ route('generate-certificate', $course['id']) }}"  target="_blank" class="btn btn-dark">Download certificate</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>


            </div>
        </div>
    </div>
    </div>
</section>
@endsection('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('/assets/enrolledCoursePage.css') }}">
@endpush
@push('child-scripts')
<script>

    let startAssignment = document.getElementsByClassName('start_assignment');

    let startAssignmentLength = startAssignment.length;

    for(index = 0;index < startAssignmentLength;index++) {
        startAssignment[index].addEventListener('click', function(e) {
            e.preventDefault();
            let card = this.getAttribute('card-id');

            document.getElementById('card_' + card).style.display = "block";
        });
    }
    let finalRating = 0;

    let stars = document.getElementsByClassName('rating-star');
    for (var index = 0; index < stars.length; index++) {
        stars[index].addEventListener('click', function(event) {
            let starRating = parseInt(this.getAttribute('star-rating'));

            finalRating = starRating;
            
            console.log(finalRating);
            for (var i = 0; i < starRating; i++) {
                stars[i].classList.add("active-stars");
            }
            for (var i = starRating; i > index; i++) {
                stars[i].classList.remove("active-stars");
            }
        });
    }

    document.getElementById('reviewModal').addEventListener('hide.bs.modal', function(event) {
        let starElement = document.getElementsByClassName('rating-star');
        for (var i = 0; i < 5; i++) {
            starElement[i].classList.remove("active-stars");
        }
        document.getElementById('comment').value = "";
    });

    document.getElementById('reviewSubmitBtn').addEventListener('click', (event) => {

        let courseId = document.getElementById('course_id').value;
        let userId = document.getElementById('user_id').value;
        let comment = document.getElementById('comment').value;

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
            if (data.status == 'success') {
                closeModal('reviewModal');
                // window.location.reload();
            }
        });

    });

    function closeModal(modalId) {
        const truck_modal = document.querySelector('#' + modalId);
        const modal = bootstrap.Modal.getInstance(truck_modal);
        modal.hide();
    }


let replyEle = document.getElementsByClassName('replyBtn');
let replyEleCount = replyEle.length;

for(index = 0;index < replyEleCount;index++) {
    replyEle[index].addEventListener('click', function(e) {
        qaId = this.getAttribute('data-id');
        replyContent = document.getElementById('reply_' + qaId).value;
        let path = "{{ route('reply.to.student') }}?qaId=" + qaId + "&replyContent=" + replyContent;
     
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
                document.getElementById("replyDiv_" + qaId).style.display = "block";
                document.getElementById('replyContent_' + qaId).innerHTML = data.reply;
                document.getElementById('updatedAt_' + qaId).innerHTML = data.updatedAt;
                document.getElementById("replyTextArea_" + qaId).style.display = "none";
            }
        });
    });
}

document.getElementById('submitStudentQuestion').addEventListener('click', function(e) {
    let question = document.getElementById('studentQuestion').value;
    let path = "{{ route('ask.question') }}?question=" + question + '&course_id=' + document.getElementById('course_id').value;
     
        fetch(path, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            },
           body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
            if(data.status == "success") {
                location.reload();
            }
        });
});
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Sub content', 'Likes', 'Dislikes'],
            <?php
            if(isset($graph)) {
                foreach ($graph as $gr) {
                    echo '["' . $gr['topic_title'] . '",' . $gr['likes'] . ',' . $gr['dislikes'] . '],';
                }
            }
            
            ?>
        ]);


        var options = {
            chart: {
                title: 'Session wise Likes and Dislikes',
                subtitle: '',
                width: 600,
                height: 400
            },
            colors: ['#A26B05','#F5BC29']
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
@endpush
