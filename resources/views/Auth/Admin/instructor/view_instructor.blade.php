@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
  <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        @csrf
        <section class="row g-3 llp-view">
        <div class="py-4"><h3 class="titles">Instructor details</h3></div>
          <div class="col-md-2">
          <img src="{{ asset('/storage/images/'.$instructorDetails['instructor_image']) }}" class="img-fluid rounded-circle float-start" alt="" style="width:94px; height:94px;">
       </div>
        <div class="col-md-3">
            <label>First Name</label>
            <p>{{$instructorDetails['firstname']}}</p>
          </div>
          <div class="col-md-3">
            <label>Last Name</label>
            <p>{{$instructorDetails['lastname']}}</p>
          </div>
          <div class="col-md-3">
            <label>Email id</label>
            <p>{{$instructorDetails['instructor_email']}}</p>
          </div>

          <div class="row d-flex justify-content-end">
            <div class="col-md-3">
              <label>Institute</label>
              <p>{{$instructorDetails['instructor_institute'] == "" ? 'None' : $instructorDetails['instructor_institute']}}</p>
            </div>
            <div class="col-md-3">
              <label>Designation</label>
              <p>{{$instructorDetails['instructor_designation'] == "" ? 'None' : $instructorDetails['instructor_designation']}}</p>
            </div>

            <div class="col-md-4">
              <label>Twitter Link</label>
              <p>{{$instructorDetails['instructor_twitter_social'] == "" ? 'None' : $instructorDetails['instructor_twitter_social']}}</p>
            </div>
          </div>
          <div class="row d-flex justify-content-start mt-3">
            <div class="col-md-4">
              <label>LinkedIn Link</label>
              <p>{{$instructorDetails['instructor_linkedin_social'] == "" ? 'None' : $instructorDetails['instructor_linkedin_social']}}</p>
            </div>

            <div class="col-md-6">
              <label>Youtube Link</label>
              <p>{{$instructorDetails['instructor_youtube_social'] == "" ? 'None' : $instructorDetails['instructor_youtube_social']}}</p>
            </div>

            <div class="col-md-12">
              <label>About</label>
              <p>{{$instructorDetails['instructor_description']}}</p>
            </div>

            <div class="col-md-12">
              <div class="row">
                <div class="col-lg-3">
                    <label>Signature</label>
                </div>
                <div class="col-lg-8">
                <img src="{{ asset('/storage/signatures/'.$instructorDetails['instructor_signature']) }}" class="img-fluid float-start" alt="" style="width:300px; height:94px;">
                </div>
              </div>
            </div>
          </div>         

          <div class="col-12">
            <label>Assigned courses</label>
            <ul>
              @if(count($assigned_courses) != 0)
                @foreach($assigned_courses as $assigned_course)
                <li>{{ $assigned_course->course_title }}</li>
                @endforeach
              @else
                  <p>None</p>
              @endif
            </ul>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <a class="btn btn-outline-secondary" href="{{route('manage-instructors')}}">Cancel</a>
            <a class="btn btn-primary" href="{{route('edit-instructor', ['instructor_id' => $instructorDetails['instructor_id']])}}">Edit instructor</a>
          </div>
          </section>
      </main>
    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
