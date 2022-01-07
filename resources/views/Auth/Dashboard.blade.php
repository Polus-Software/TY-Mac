@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
    <div class="col-2 position-fixed">
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        @if($userType == "admin")
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
                <h1 class="card-title">180</h5>
                  <p class="card-text">Total Live Hours</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row mt-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3>Upcoming cohorts</h3>
          </div>
        
              <table class="table llp-table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Instructor</th>
                    <th scope="col">Participants</th>
                    <th scope="col">Date/Time</th>
                    <th scope="col" class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @php ($slno = 0)
               @foreach($upComingSessionDetails as $upComingSessionDetail)
                @php ($slno = $slno + 1)
                  <tr id="">
                    <td>{{$slno}}</td>
                    <td>{{$upComingSessionDetail['session_title']}}</td>
                    <td>{{$upComingSessionDetail['instructor']}}</td>
                    <td>{{$upComingSessionDetail['enrolledCourses']}}</td>
                    <td>{{$upComingSessionDetail['date']}}</td>
                    
                    
                    <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
                  </tr>
                 @endforeach
                </tbody>
              </table>
              
         
        </div>
        <div class="row mt-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3>Recent cohorts</h3>
          </div>
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Instructor</th>
                <th scope="col">Participants</th>
                <th scope="col">Date/Time</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @php ($slno = 0)
            @foreach($recentSessionDetails as $recentSessionDetail)
              @php ($slno = $slno + 1)
              <tr>
                <td>{{ $slno }}</td>
                <td>{{$recentSessionDetail['session_title']}}</td>
                <td class="text-capitalize"></td>
                <td></td>
                <td></td>
                <td class="text-center"><i class="fas fa-ellipsis-v"></i></td>
              </tr>
           @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
@endsection
