@extends('Layouts.admin.master')
@section('content')
<!-- @include('Layouts.admin.header') -->
@extends('header')
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
    <div class="left_sidebar">
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        @if($userType == "admin" || $userType == "content_creator")
        <div class="row mt-4">
          <div class="col-12 col-lg-3 col-md-3 col-sm-6">
            <div class="card llp-countbox mb-3">
              <div class="card-body text-center">
                <h1 class="card-title">{{$registered_course_count}}</h5>
                  <p class="card-text">Course registered</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 col-md-3 col-sm-6">
            <div class="card llp-countbox mb-3">
              <div class="card-body">
                <h1 class="card-title text-center">{{$students_registered}}</h5>
                  <p class="card-text text-center">Total students joined</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 col-md-3 col-sm-6">
            <div class="card llp-countbox mb-3">
              <div class="card-body text-center">
                <h1 class="card-title">{{$instructor_count}}</h5>
                  <p class="card-text">Total instructor</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 col-md-3 col-sm-6">
            <div class="card llp-countbox mb-3">
              <div class="card-body text-center">
                <h1 class="card-title">{{$total_live_hours}}</h5>
                  <p class="card-text">Total Live Hours</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row mt-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3 class="titles">Upcoming cohorts</h3>
          </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
              <table class="table llp-table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Instructor</th>
                    <th class="text-center" scope="col">Participants</th>
                    <th scope="col">Date/Time</th>
                  </tr>
                </thead>
                <tbody>
                @php ($slno = 0)
                @if(!empty($upComingSessionDetails))
               @foreach($upComingSessionDetails as $upComingSessionDetail)
                @php ($slno = $slno + 1)
                  <tr id="">
                    <td>{{$slno}}</td>
                    <td>{{$upComingSessionDetail['session_title']}}</td>
                    <td>{{$upComingSessionDetail['instructor']}}</td>
                    <td class="text-center">{{$upComingSessionDetail['enrolledCourses']}}</td>
                    <td>{{$upComingSessionDetail['date']}}</td>
                  </tr>
                 @endforeach
                  @else
                  <tr>
                      <td colspan="5"><h6 style="text-align:center;">No upcoming cohorts.</h6></td>
                  </tr>
                  @endif
                </tbody>
              </table>
              
			</div>
        </div>
        <div class="row mt-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3 class="titles">Recent cohorts</h3>
          </div>
		  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Instructor</th>
                <th class="text-center" scope="col">Participants</th>
                <th scope="col">Date/Time</th>
              </tr>
            </thead>
            <tbody>
              @php ($slno = 0)
              @if(!empty($recentSessionDetails))
            @foreach($recentSessionDetails as $recentSessionDetail)
              @php ($slno = $slno + 1)
              <tr>
                <td>{{ $slno }}</td>
                <td>{{$recentSessionDetail['session_title']}}</td>
                <td>{{$recentSessionDetail['instructor']}}</td>
                <td class="text-center">{{$recentSessionDetail['enrolledCourses']}}</td>
                <td>{{$recentSessionDetail['date']}}</td>
              </tr>
           @endforeach
           @else
                 <tr>
                     <td colspan="5"><h6 style="text-align:center;">No recent cohorts.</h6></td>
                 </tr>
                 @endif
            </tbody>
          </table>
		  </div>
        </div>
        @endif
      </main>
      <!-- main ends -->

    </div>
	<div class="col-md-1"></div>
  </div>
</div>
@endsection
