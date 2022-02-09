@extends('Layouts.app')
@section('content')
<style>
    .card-text-1.team_text{
    padding-bottom:40px;
}
.completion_info{
    line-height:30px;
}
.card.pill_card{
    border:0;
}
.complete_warning{
    display: block;
    color: #6E7687;
}
.welcome_text{
    color: #af7e00;
    font-weight: bold;
    margin: 20px 0 8px 0;
    display: block;
}
.download_certificate,.download_certificate:hover,.download_certificate:focus{
    background: #F1EEFD;
    color:#6c757d;
    float:right;
}
.not_completed .card-body{
    padding:100px 0;
}
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
    /* color:#F5BC29; */
    color:#af7e00;
    text-align: center;
    padding-bottom: 40px;
    /* padding-top:20px; */
    padding-top:40px;
    font-family: 'Roboto', sans-serif;
    font-weight: 900;
    font-size:28px;
   
}
.card-text-1.team_text{
    padding-bottom:40px;
}
.completion_info{
    line-height:30px;
}
.card.pill_card{
    border:0;
}
.complete_warning{
    display: block;
    color: #6E7687;
}
.welcome_text{
    color: #af7e00;
    font-weight: bold;
    margin: 20px 0 8px 0;
    display: block;
}
.download_certificate,.download_certificate:hover,.download_certificate:focus {
    background: #F1EEFD;
    color:#6c757d;
    float:right;
}
.not_completed .card-body{
    padding:100px 0;
}
#reviewButton{
    border: 1px solid #d1d0d0;
    padding: 6px 25px;
}
.card-text-1-certificate{
    text-align: center;
    font-family: 'Roboto', sans-serif;
    font-weight: 400; 
    color: #6E7687;
    padding-bottom:0px;
    font-size:25px;
    width:60%;
    display:inline-block;
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

.chart-modal-body {
    height: 31rem;
}
.chart-modal-header {
    padding: 1.5rem 1rem 1rem 4rem;
    height: 4rem;
    border-bottom: none;
}
.session-modal-header {
    padding: 2.5rem 1rem 2rem 3rem;
    height: 4rem;
    border-bottom: none;
}
.session-text {
    font-size: 14px;
    font-weight: 500;
    color: #a6a6a6;
}
.session-modal-footer {
    border-top:none;
}
.session-modal-body {
    padding: 1rem 3rem 3rem 3rem;
}
.instructor-assignment-table th {
    color: #2C3443;
    font-size: 14px;
}
.instructor-assignment-table, .instructor-assignment-table tr, .instructor-assignment-table td {
    border: 1px solid #dee2e6;
}
.assign-modal-header {
    border-bottom : none;
    padding: 1.5rem 3rem 0 3rem;
}
.assignment_list_div {
    border: 1px solid #cacaca;
    border-radius: 15px;
    padding: 20px 20px 20px 20px;
    margin-top: 25px;
}
.assignment_list_div a {
    float: right;
    margin-top: -5px;
    background-color: #fff;
    color: #666666;
    font-size: 12px;
    border-color: #cacaca;
}
.assign_cancel {
    background-color: #fff;
    color: #666666;
    font-size: 12px;
    border-color: #cacaca;
}
#assign_completed {
    font-size: 12px;
}
span#assignment_title {
    font-size: 13px;
    font-weight: 600;
}
.assignment-modal-heading {
    font-weight: 700;
    font-size: 24px;
}

#add_comment {
    position: relative;
    left: -14.3rem;
}
#modal_student_img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

span#assignment_table_student {
    position: relative;
    left: 10px;
}

small#assignment_table_batch {
    position: relative;
    left: 40px;
}
#copy-link{
    position: absolute;
    top: 8.5rem;
    color: #6c757d;
    font-size: 13px;
    cursor: pointer;
}
#copy-link:hover{
    text-decoration: underline;
}

#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #74648C;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

  </style>
  <div id="snackbar">Link copied.</div>
  <!-- instructor assignment modal -->
  <div class="modal fade" id="instructAssignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="width: 35rem;">
      <div class="modal-header assign-modal-header">
        <h5 class="assignment-modal-heading" id="exampleModalLabel">Assignment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding: 0 3rem 0rem 3rem;">
        <h6 class="mt-4" style="font-size: 14px;font-weight: 500;">Topic</h6>
        <h6 id="modal_topic_title" class="mt-1" style="font-size: 14px;font-weight: 500;">Topic</h6>
        <table class="mt-3 w-100">
            <tr>
                <td><img src="" id="modal_student_img"/></td>
            <td colspan="1" style="font-size: 14px;font-weight: 600;"><span id="modal_student_name">Angeline Rozario</span><br>
                <small class="text-truncate">Batch: <span id="modal_batch_name" style="color:#6a6a6a;font-weight:500;">Cohort 2</span></small>
            </td>
            <td style="text-align:right;vertical-align:bottom;"><small style="font-size: 12px;color:#6a6a6a;font-weight:500;">1 Document Attached</small></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="assignment_list_div">
                        <span id="assignment_title">Assignment Title</span>
                        <a id="modal_file_download" href="" class="btn btn-secondary" target="_blank" style="float: right;"><i class="fa fa-download"></i> Download File</a>
                    </div>
                </td>
                
            </tr>
        </table>
        <div id="modal_comment_div" class="llpcard-inner bg-light mt-3 mb-3" style="padding: 1rem 1rem 3rem 1rem;display:none;">
                                            <h5 style="font-size: 13px;font-weight:500;" class="card-title">Type your comment here</h5>
                                                                             
                                            @csrf
                                            <input type="hidden" name="assignment_id"  id ="assignment_id" value="" />
                                            <textarea style="font-size: 13px;font-weight:500;" style="height: 110px;" class="form-control" type="text" name="assignment_comment" placeholder="Type your comment here.."></textarea>
                                        </div>
      </div>
      
      <div class="modal-footer" style="border-top:none;">
        <button id="add_comment" type="button" class="btn btn-secondary assign_cancel">Add comment</button>
        <button type="button" class="btn btn-secondary assign_cancel" data-bs-dismiss="modal">Cancel</button>
        <button id="assign_completed" type="button" class="btn btn-secondary" data-assignment="" >Completed</button>
      </div>
    </div>
  </div>
</div>
  <!-- Modal ends here -->
  <!-- 1 on 1 modal -->
  <div class="modal fade" id="sessionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header session-modal-header">
        <h5 class="modal-title" id="sessionModalLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body session-modal-body">
        <p class="session-text">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </p>
      </div>
      <div class="modal-footer session-modal-footer">
        <button style="color: #5c636a;background-color: #fff;font-size: 13px;" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="1_on_1_session_start" style="font-size: 13px;" type="button" class="btn btn-secondary" data-student-id="" data-topic-id="">Continue</button>
      </div>
    </div>
  </div>
</div>
<!-- 1 on 1 modal ends here -->
<!-- Chart modal -->

  <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header chart-modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body chart-modal-body">
        <div id="graph_div">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<header class="d-flex align-items-center mb-3 mt-4">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card card-1  border-0 mb-3 mt-4 mw-100">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            @foreach($singleCourseDetails as $course)
                            <img src="{{asset('/storage/courseThumbnailImages/'.$course['course_thumbnail_image'])}}" class="img-fluid col-md-12 col-sm-12 col-12 h-100 course-image" alt="coursepicture">
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
                                             
                                               
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6 text-end">
                                            @if($userType == 'instructor')
                                            <input type="hidden" id="batch_id" value="{{ $selectedBatch }}">
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
        <div class="row mb-5">
            <div class="col-lg-3 col-md-4 col-sm-12 col-12 vertcalNav mb-3">
                <div class="row sidebar pt-4">
                    <h3 class="ps-4">Cohort Details</h3>
                    <div class="nav flex-column nav-pills d-flex align-items-start pe-0 pt-4 pb-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if($userType == 'instructor')
                        <button class="nav-link align-items-center mb-2 ps-4 pe-4 d-flex text-start active" id="v-pills-cohortOverview-tab" data-bs-toggle="pill" data-bs-target="#cohort-overview" type="button" role="tab" aria-controls="v-pills-cohortSchedule" aria-selected="true">
                            <i class="fas fa-chart-bar pe-3"></i><span>Cohort Overview</span>
                        </button>
                        @endif
                        <button class="nav-link align-items-center {{($userType == 'student') ? 'active' : ''}} mb-2 ps-4 pe-4 d-flex text-start" id="v-pills-cohortSchedule-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cohortSchedule" type="button" role="tab" aria-controls="v-pills-cohortSchedule" aria-selected="true">
                        <img src="/storage/icons/_cohort_schedule.svg" alt="error" class="pe-3"><span>Cohort Schedule</span>
                        </button>
                        <button class="nav-link align-items-center mb-2 ps-4 pe-4 d-flex text-start" id="v-pills-personalizedRecommondations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-personalizedRecommendations" type="button" role="tab" aria-controls="v-pills-CohortQuestions" aria-selected="false">
                        <img src="/storage/icons/_personalized_recommendations.svg" alt="error" class="pe-3"><span>Personalized Recommendations</span>
                        </button>
                        <button class="nav-link align-items-center mb-2 ps-4 pe-4 d-flex text-start" id="v-pills-CohortQuestions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-CohortQuestions" type="button" role="tab" aria-controls="v-pills-CohortQuestions" aria-selected="false">
                        <img src="/storage/icons/_cohort_Q&A.svg" alt="error" class="pe-3"><span>Cohort Q&A</span>
                        </button>
                        <button class="nav-link align-items-center mb-2 ps-4 pe-4 d-flex text-start" id="v-pills-cohortInfo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cohortInfo" type="button" role="tab" aria-controls="v-pills-cohortInfo" aria-selected="false">
                        <img src="/storage/icons/_cohort_info.svg" alt="error" class="pe-3"><span>Cohort Info</span>
                        </button>
                        <button class="nav-link align-items-center mb-2 ps-4 pe-4 d-flex text-start" id="v-pills-personalizedActivity-tab" data-bs-toggle="pill" data-bs-target="#v-pills-personalizedActivity" type="button" role="tab" aria-controls="v-pills-personalizedActivity" aria-selected="false">
                        <img src="/storage/icons/_assignments.svg" alt="error" class="pe-3"><span>Personalized Activity</span>
                        </button>
                        @if($userType == 'student')
                        <button class="nav-link align-items-center mb-2 ps-4 pe-4 d-flex text-start" id="v-pills-certificate-tab" data-bs-toggle="pill" data-bs-target="#v-pills-certificate" type="button" role="tab" aria-controls="v-pills-certificate" aria-selected="false">
                        <img src="/storage/icons/_completion _certificate.svg" alt="error" class="pe-3"><span>Completion Certificate</span>
                    </button>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 border-bottom mt-3 mb-3"></div>
                        <p class="ps-4 text-start align-items-start achievement">ACHIEVEMENTS</p>

                        <div class="container achievements-badge-container d-flex">
                            <div class="badge-shadow left-0"><img src="/Badges/Badge 1.svg" alt=""></div>
                            <div class="badge-shadow left--15"><img src="/Badges/Badge 2.svg" alt=""></div>
                            <div class="badge-shadow left--30"><img src="/Badges/Badge 3.svg" alt=""></div>
                            <div class="badge-shadow left--45">
                                <button class="nav-link bg-transparent p-0" id="v-pills-achievements-tab" data-bs-toggle="pill" data-bs-target="#v-pills-achievements" type="button" role="tab" aria-controls="v-pills-achievements" aria-selected="false">
                                    <img src="/Badges/More.svg" alt="">
                                </button>
                            </div>
                        </div>
                        <div class="border-top col-12 mt-4 py-4 text-center px-4">
                            <a class="bg-transparent btn btn-dark text-black w-100" id="reviewButton" data-bs-toggle="modal" data-bs-target="#reviewModal">Add Course Review</a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-sm-12 col-12 gx-5 pe-3">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- overview tab -->
                    @if($userType == 'instructor')
                    <div class="tab-pane fade show {{($userType == 'instructor') ? 'active' : ''}}" id="cohort-overview" role="tabpanel" aria-labelledby="cohort-overview">
                       <div class="card card-2 mb-3">
                           <div class="card-body">
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

                        <div class="row border-bottom mb-3">
                            <div class="col-lg-12">
                                <h5 class="recommendation ms-2">Recommended Topics to Review</h5>
                            </div>
                        </div>
                        <div class="row border m-2">
                            <table class="table llp-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Session name</th>
                                        <th scope="col">Topic</th>
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
                    </div>
                    </div>
                    @endif
                    <!-- overview tab -->
                    <!-- schedule tab -->
                    <div class="tab-pane fade show {{($userType == 'student') ? 'active' : ''}}" id="v-pills-cohortSchedule" role="tabpanel" aria-labelledby="v-pills-cohortSchedule">
                        <div class="card card-2 mb-3">
                            <div class="card-body">
                            <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                        <h5 class="card-title pt-2">Session Info</h5>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                    @if($userType == 'student')
                                        <a class="btn btn-secondary think-btn-secondary" href="{{ route('study.materials') }}?course={{$course['id']}}">Go to study materials</a>
                                    @endif
                                    </div>
                                </div>
                                <hr>
                                @php ($sl_no=0)
                                @foreach($topicDetails as $topicDetail)
                                @php ($sl_no++)
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <h6 class="card-title pt-2" data-id="{{ $topicDetail['topic_id'] }}">Session {{$sl_no}} - {{ $topicDetail['topic_title'] }}</h6>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end mt-2">
                                        @if($topicDetail['liveId'] == null)
                                        @if($topicDetail['scheduled'] == true)
                                        <span style="font-size:14px;">Next Live Class:{{ $topicDetail['nextCohort'] }}</span>
                                        @else
                                        <span class="text-muted" style="font-size:14px;">No sessions scheduled</span>
                                        @endif
                                        @elseif($topicDetail['liveId'] == "Over")
                                        <a style="color: #6E7687;" type="button" class="btn" href="/view-again/{{ $topicDetail['overId'] }}"><i class="fas fa-undo pe-2"></i>View again</a>
                                        @elseif($topicDetail['liveId'] == "Wait")
                                        <span class="text-muted" style="font-size:14px;text-decoration:underline;">Instructor yet to join, please be patient.</span>
                                        @else
                                        <a style="background-color: #74648C;color: white;" type="button" class="btn" href="/session-view/{{ $topicDetail['liveId'] }}?batchId={{ isset($selectedBatch) ? $selectedBatch : '' }}"><i class="fas fa-eye pe-2"></i>View live session</a>
                                        <a id="copy-link" data-href="{{url('/')}}/session-view/{{ $topicDetail['liveId'] }}?batchId={{ isset($selectedBatch) ? $selectedBatch : '' }}">Copy link to session</a>
                                        @endif
                                    </div>
                                </div>
                                @if($loop->count == $loop->iteration)
                                <ul class="list-group list-group-flush pb-3">
                                @else
                                <ul class="list-group list-group-flush border-bottom pb-3">
                                @endif
                                    @foreach($topicDetail['topic_content'] as $content)
                                    <li class="ms-3 border-0 pb-2" style="list-style:circle;">{{ $content->topic_title }}</li>
                                    @endforeach
                                </ul>
                                @endforeach
                            </div>
                        </div>
                        @if($userType == 'student')
                        <div class="row border-bottom">
                            <div class="col-lg-12">
                                <h5 class="recommendation">Recommended Topics to Review</h5>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            @forelse($recommendations as $recommendation)
                            <div class="col-lg-6 mb-3">
                                <div class="card card-3">
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
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <h6 class="card-title">{{ $recommendation['topic_title'] }}</h6>
                                                <ul class="list-group list-group-flush border-bottom pb-3">
                                                    <li class="ms-3 border-0 pb-2">{{ $recommendation['content_title'] }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                             <x-nodatafound message="No recommendations for you yet!"  notype=""/>
                            @endforelse
                        </div>
                        @endif

                    </div>
                    <!-- schedule tab -->
                    <!-- Recommendations tab -->
                    <div class="tab-pane fade" id="v-pills-personalizedRecommendations" role="tabpanel" aria-labelledby="v-pills-personalizedRecommendations-tab">
                        <div class="card card-2">
                            <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-lg-6">
                                <h5 class="heading-1">{{($userType == 'student') ? 'Recommended Topics to Review' : 'Personalized Recommendations'}}</h5>
                            </div>
                            @if($userType == 'instructor')
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-lg-end justify-content-md-end mb-2">
                            <form class="mb-2 mb-lg-0 mt-lg-0 d-flex mt-3 col-md-9 col-sm-9 col-6">
                                @csrf
                                <input class="form-control me-2" type="search" placeholder="Search a name" aria-label="Search" id="search-box">
                                <button class="btn btn-outline-dark" type="button" id="search-btn">Search</button>
                            </form>
                            </div>
                            @endif
                        </div>
                        @if($userType == 'student')
                        <div class="row mt-3 mb-3">
                        @foreach($recommendations as $recommendation)
                            <div class="col-lg-6 mb-3">
                                <div class="card card-3">
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
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <h6 class="card-title">{{ $recommendation['topic_title'] }}</h6>
                                                <ul class="list-group list-group-flush border-bottom pb-3">
                                                    <li class="ms-3 border-0 pb-2">{{ $recommendation['content_title'] }}</li>
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
                                <div class="accordion-item border-0 bg-light">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button shadow-none text-capitalize mb-2p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{ $student->id }}" aria-expanded="true" aria-controls="collapseOne_{{ $student->id }}">
                                        <img src="{{ asset('/storage/images/user.png') }}"  class="rounded-circle me-3" alt="" style="width:40px; height:40px;"><p class="pt-3 card-title-4">{{ $student->firstname .' '. $student->lastname }}</p>
                                        <a href="#" class="btn btn-outline-secondary text-dark ms-auto"><i class="fas fa-comments pe-2"></i>Message</a>
                                    </button>
                                       
                                    </h2>
                                    <div id="collapseOne_{{ $student->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body bg-white ps-5 pe-5">
                                            <div class="row mt-3 mb-3">
                                                @foreach($recommendations as $recommendation)
                                                @if($recommendation['student_id'] == $student->user_id)
                                                <div class="col-lg-6 mb-3">
                                                    <div class="card card-3" style="height: 550px;">
                                                        <img src="/courselist/Illustration/Mask Group 2.jpg" class="card-img-top img-fluid" alt="...">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#sessionModal"  data-bs-student-id="{{$recommendation['student_id']}}"  data-bs-topic-id="{{$recommendation['topic_id']}}">1-on-1 Session</button>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                   <button type="button" class="btn btn-outline-secondary text-dark w-100" data-bs-toggle="modal" data-bs-target="#chartModal" data-bs-student-id="{{$recommendation['student_id']}}"  data-bs-topic-id="{{$recommendation['topic_id']}}">Chart</button>
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
                                                                            <ul class="list-group list-group-flush pb-3 mt-3">
                                                                                <li class="ms-3 border-0 pb-2">{{ $recommendation['content_title'] }}</li>
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
                        </div>
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
                                                                <p class="text-end time" id="updatedAt_{{ $qa['id'] }}">{{ $qa['replay_date'] }}</p>
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
                                    <div class="row g-0 border-bottom think-bg think-br">
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
                    @if($userType == 'instructor')
                    <div class="tab-pane fade" id="v-pills-personalizedActivity" role="tabpanel" aria-labelledby="v-pills-personalizedActivity-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-2">
                                    <div class="card-body p-4">
                                        <h5 class="card-title border-bottom pt-2 pb-2">Personalized Activity Info</h5>

                                        
                                        <table class="table llp-table instructor-assignment-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" colspan="2">Name</th>
                                                    <th></th>
                                                    @php ($aSlNo = 0)
                                                    @foreach($assignments as $assignment)
                                                    @php ($aSlNo = $aSlNo + 1)
                                                    <th scope="col"><small style="color:#7e8c9a;">Assignment {{ $aSlNo }}</small><br>{{ $assignment->assignment_title }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($assignmentArr as $assignment)
                                                <tr>
                                                    
                                                    <td colspan="3" style="font-size: 14px;font-weight: 600;"><img src="/storage/images/{{ $assignment['studentImg'] }}" id="modal_student_img"/><span id="assignment_table_student">{{ $assignment['student_name'] }}</span><br>
                                                        <small id="assignment_table_batch" class="text-truncate">Batch: <span  style="color:#6a6a6a;font-weight:500;">{{ $assignment['batch_name'] }}</span></small>
                                                    </td>
                                                    
                                                    @foreach($assignment['assignment_data'] as $data)
                                                    @if($data['status'] == 'Submitted')
                                                        <td style="vertical-align: middle;font-size: 13px;color:#74648C;" id="{{ $data['assignment_id'] }}"><i class="fas fa-file"></i> <a style="color:#74648C;" href="#" data-bs-toggle="modal" data-bs-target="#instructAssignModal" bs-data-assignment="{{ $data['stuAssignment'] }}"> {{ $data['status'] }}</a></td>
                                                    @elseif($data['status'] == 'Pending')
                                                        <td style="vertical-align: middle;font-size: 13px;background-color: #ffefc5;color: #9c791c;padding-left: 25px;" id="{{ $data['assignment_id'] }}"><i class="far fa-clock"></i> {{ $data['status'] }} </td>
                                                    @elseif($data['status'] == 'Completed')
                                                        <td style="vertical-align: middle;font-size: 13px;background-color: #e4ffe4;color: #4aa24a;padding-left: 25px;" id="{{ $data['assignment_id'] }}"><i class="fa fa-check-double"></i> {{ $data['status'] }} </td>
                                                    @endif
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($userType == 'student')
                    <div class="tab-pane fade" id="v-pills-personalizedActivity" role="tabpanel" aria-labelledby="v-pills-personalizedActivity-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-2">
                                    <div class="card-body p-4">
                                        <h5 class="card-title border-bottom pt-2 pb-2">Personalized Activity Info</h5>

                                        @php ($slno = 0)
                                        @foreach($topicDetails as $topicDetail)
                                        @php ($slno = $slno + 1)
                                    
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed plus" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree_{{$slno}}" aria-expanded="false" aria-controls="collapseThree">
                                                Session {{$slno}} - {{$topicDetail['topic_title']}}
                                                @if($topicDetail['isAssignmentSubmitted'] == true && $topicDetail['isAssignmentCompleted'] == true)
                                                <span style="position:absolute;left:45rem;background-color:#b8ffb0 !important;width:6rem;" class="badge pill text-dark">Completed</span>
                                                @elseif($topicDetail['isAssignmentSubmitted'] == true)
                                                <span style="position:absolute;left:45rem;background-color:#b8ffb0 !important;width:6rem;" class="badge pill text-dark">Submitted</span>
                                                @else
                                                <span style="position:absolute;left:45rem;background-color:#f5bc29 !important; width:6rem;" class="badge pill text-dark">Pending</span>
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
                                                                                <a target="_blank" href="/storage/assignmentAttachments/{{$assignment['document']}}">{{$assignment['document']}}</a></p>
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
                                                                                        <input type="hidden" name="assignment_id"  id ="assignment_id" value="{{ $assignment['id'] }}" />
                                                                                        <textarea style="height: 110px;" class="form-control" type="text" name="assignment_comment" placeholder="Type your comment here.."></textarea>
                                                                                            <div class="card card-body mb-3" style="background-color: transparent;background-clip: border-box;border: none;"> 
                                                                                                <div class="row p-2 flex-fill bd-highlight">
                                                                                                    <div class="col-lg-3">Attach File:</div>
                                                                                                        <div class="col-lg-6 col-12"><label>Upload from device</label>
                                                                                                            <input class="form-control" type="file" name="assignment_upload">
                                                                                                            <small class="fst-italic">Supported File Formats are:  ppt, pdf, doc, docx,</small>
                                                                                                        </div>
                                                                                            <!-- <div class="col-lg-3 pt-4"><a class="btn btn-sm btn-outline-secondary" style="height: 37px;line-height: 27px;">Add external link</a></div> -->
                                                                                                    </div>
                                                                                                    <div class="col-12 text-end mt-4">
                                                                                                        <a class="btn btn-sm btn-outline-secondary me-3">Cancel</a>
                                                                                                        <button type="submit" style="font-size: 14px;font-weight: 100;color: #ffffff;" class="btn btn-sm btn-dark">Submit</a>
                                                                                                    </div>
                                                                                    </form>
                                                                                    </div>
                                                                                </div>       
                                                                            </div>                                                                               <!-- </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($topicDetail['isAssignmentSubmitted'] == true && $topicDetail['isAssignmentCompleted'] == true)
                                                    <div class="col-12 m-auto text-center">
                                                        <h3>Assignment Completed</h3>
                                                        </div>
                                                    @elseif($topicDetail['isAssignmentSubmitted'] == true)
                                                        
                                                    <div class="col-12 m-auto text-center">
                                                        <h3>Assignment Submitted</h3>
                                                        </div>
                                                    @else
                                                    <div class="col-4 m-auto text-center">
                                                        <a card-id="{{ $topicDetail['topic_id'] }}" class="btn btn-sm btn-dark me-3 start_assignment" href="">Start Assignment</a>
                                                        </div>
                                                    @endif
                                                
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
                                                </div>
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-center">
                                                @if($progress == 100)
                                                    <div class="tab-content" id="pills-tabContent">
                                                        <div class="tab-pane fade" id="pills-back" role="tabpanel" aria-labelledby="pills-back-tab">
                                                            No certificates
                                                        </div>
                                                        <div class="tab-pane fade show active" id="pills-certificate" role="tabpanel" aria-labelledby="pills-back-certificate">
                                                            <div class="col-lg-12 d-flex justify-content-center">
                                                                <div class="card text-center pill_card" style="margin: auto; width: 100%;">
                                                                    <div class="card-body">
                                                                        <small style="position: absolute; left: 0px; top:20px; left:40px;">Thinklit</small>
                                                                        <small style="position: absolute; right: 40px; top:20px;text-align:left;">
                                                                            <span style="color:#6E7687;">DATE OF ISSUE :</span>  
                                                                            <span class="date_of_issue">
                                                                            @foreach($singleCourseDetails as $course)
                                                                                {{ $course['date_of_issue'] }} 
                                                                                @endforeach
                                                                            </span>
                                                                        </small>
                                                                        <small style="position: absolute; right: 45px; top:40px;"></small>
                                                                        <img src="/storage/icons/ty_mac__transparent__1000.png" alt="" class="img-fluid" style="width:180px; height:180px;">
                                                                        <!-- <h1 class="card-title-certificate" style="margin-top:20px;">ThinkLit</h1> -->
                                                                        <div style="background:#FFFEF5;">
                                                                            <h3 class="card-title-1-certificate">Certificate of completion</h3>
                                                                            <p class="card-text-2-certificate">@foreach($singleCourseDetails as $course)
                                                                                        {{ $course['student_firstname'] }} {{ $course['student_lastname'] }}
                                                                                        @endforeach</p>
                                                                                        <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <p class="card-text-1 completion_info">Has successfully completed the {{$course['course_title']}}  <br>
                                                                                        online cohort on {{$course_completion}}</p>
                                                                                </div>
                                                                            </div>1
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
                                                                                    <p class="card-text-1 team_text">&<br>Team ThinkLit</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                <div class="card text-center pill_card not_completed" style="margin: auto; width: 100%;">
                                                    <div class="card-body">
                                                        <img src="{{asset('/storage/images/Page-1.png')}}" alt="" class="img-fluid">
                                                        <p class="card-text-2-certificate-1"><span class="welcome_text">Hi 
                                                            @foreach($singleCourseDetails as $course)
                                                                {{ $course['student_firstname'] }} {{ $course['student_lastname'] }}
                                                            @endforeach
                                                            , you haven't finished the course yet!</span>
                                                            <span class="complete_warning">Complete the course to get certificate</span>
                                                        </p>
                                                    </div>
                                                    </div>
                                                    @endif
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
    var url_string = window.location.href
    var url = new URL(url_string);
    var c = url.searchParams.get("feedback");
    if(c == true || c == 'true') {
        document.getElementById('reviewButton').click();
    }
    
    document.getElementById('copy-link').addEventListener('click', function(e) {
        navigator.clipboard.writeText(this.getAttribute('data-href'));
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    });

var instructModal = document.getElementById('instructAssignModal')
instructModal.addEventListener('show.bs.modal', function (event) {
  document.getElementById('modal_comment_div').style.display = "none";
  document.getElementById('add_comment').style.display = "block";
  var button = event.relatedTarget
  var assignment = button.getAttribute('bs-data-assignment');
  
  document.getElementById('assign_completed').setAttribute('data-assignment', assignment);
  let batch_id = document.getElementById('batch_id').value;
  let path = "{{ route('get-instructor-assignment-modal') }}?assignment_id=" + assignment + "&batch_id=" + batch_id;
        
            fetch(path, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": document.querySelector('input[name=_token]').value
                },
            body: JSON.stringify({})
            }).then((response) => response.json()).then((data) => {
                document.getElementById('modal_topic_title').innerHTML = data.assignmentTitle;
                document.getElementById('modal_student_name').innerHTML = data.studentName;
                document.getElementById('modal_batch_name').innerHTML = data.batchName;
                document.getElementById('assignment_title').innerHTML = data.assignmentTitle;
                document.getElementById('modal_student_img').src = "/storage/images/" + data.studentImg;
                document.getElementById('modal_file_download').href = "/storage/assignmentAnswers/" + data.assignmentDoc;
            });
});

document.getElementById('assign_completed').addEventListener('click', function(e) {

    let assignment = this.getAttribute('data-assignment');
    let path = "{{ route('complete-assignment') }}?assignment_id=" + assignment;
        
            fetch(path, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": document.querySelector('input[name=_token]').value
                },
            body: JSON.stringify({})
            }).then((response) => response.json()).then((data) => {
                window.location.reload();
            });
});

    document.getElementById('add_comment').addEventListener('click', function(e) {
        document.getElementById('modal_comment_div').style.display = "block";
        this.style.display = "none";
    });

    let startAssignment = document.getElementsByClassName('start_assignment');

    let startAssignmentLength = startAssignment.length;

    for(index = 0;index < startAssignmentLength;index++) {
        startAssignment[index].addEventListener('click', function(e) {
            e.preventDefault();
            let card = this.getAttribute('card-id');

            document.getElementById('card_' + card).style.display = "block";
            this.style.display = "none";


            let assignmentId = document.getElementById('assignment_id').value;
            let path = "{{ route('start.assignment.post') }}?assignment_id=" + assignmentId;
        
            fetch(path, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": document.querySelector('input[name=_token]').value
                },
            body: JSON.stringify({})
            }).then((response) => response.json()).then((data) => {
               
            });
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
            if(data.status == 'success') {
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
@if($userType == 'instructor')
<script>
    
    
            function drawChart(count, contents, student) {
                console.log(contents[0]['likes']);
                var gdata = new google.visualization.DataTable();
                gdata.addColumn('string', 'Subtopics');
                gdata.addColumn('number', 'Feedbacks');
                for(i=0;i<count;i++){
                    gdata.addRows([
                        [contents[i]['content_title'],contents[i]['likes']]
                    ]);
                }
                
                var options = {
                chart: {
                    title: student + "'s Activities"
                },
                width: 900,
                height: 470,
                colors: ['#A26B05'],
                vAxis: {
                    format: '0'
                    },
                };
                var chart = new google.charts.Line(document.getElementById('graph_div'));
                chart.draw(gdata, google.charts.Line.convertOptions(options));
            }
      
    let contentCount = 0;
    let contentArr = [];
    document.getElementById('sessionModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var student = button.getAttribute('data-bs-student-id');
        var topic = button.getAttribute('data-bs-topic-id');
        startBtn = document.getElementById('1_on_1_session_start');
        startBtn.setAttribute('data-student-id', student);
        startBtn.setAttribute('data-topic-id', topic);
    });
    document.getElementById('1_on_1_session_start').addEventListener('click', function(e) {
        var student = this.getAttribute('data-student-id');
        var topic = this.getAttribute('data-topic-id');
        var batch_id = document.getElementById('batch_id').value;
        
        location.replace("/1-on-1/" + student + "/" + topic + "?batchId=" + batch_id);
    });
    
    document.getElementById('chartModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var student = button.getAttribute('data-bs-student-id');
        var topic = button.getAttribute('data-bs-topic-id');
        var course = document.getElementById('course_id');
        
        let path = "{{ route('get-individual-student-chart') }}?student=" + student +"&topic=" + topic +"&course=" + course;
        fetch(path, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
          },
        }).then((response) => response.json()).then((jsondata) => {
            google.charts.load('current', {'packages':['line']});
            
            google.charts.setOnLoadCallback(function(){ drawChart(jsondata.contentCount, jsondata.contents, jsondata.student) });
        });
        setTimeout(hideAxisLabels, 500);
        function hideAxisLabels(){
            let axisElements = document.getElementById('graph_div').getElementsByTagName('g')[4].getElementsByTagName('text');   
            let axisElementsLength = axisElements.length;
            axisElements[parseInt(axisElementsLength) - 2].style.display = 'none';
            axisElements[parseInt(axisElementsLength) - 4].style.display = 'none';
            let title = document.getElementById('graph_div').getElementsByTagName('g')[0].getElementsByTagName('text')[0];
            title.setAttribute('fill', '#2C3443');
            title.style.fontSize = "16px";
            title.style.fontWeight = "600";
            let lineElement = document.getElementById('graph_div').getElementsByTagName('g')[2]; 
            let path = lineElement.getElementsByTagName('path')[0];
            let circle = lineElement.getElementsByTagName('circle');
            path.setAttribute('stroke-width', '4');
            for(i=0;i<circle.length;i++){
                circle[i].setAttribute('fill-opacity', 1);
            }
        }
    });
</script>
@elseif($userType == 'student')
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
@endif
@endpush
