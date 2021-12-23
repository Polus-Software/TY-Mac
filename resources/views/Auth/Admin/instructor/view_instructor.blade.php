@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
  <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        @csrf
        <section class="row g-3 llp-view">
        <div class="py-4"><h3>Instructor details</h3><hr class="my-4"></div>

<div class="col-md-2"><i class="fas fa-user-circle fa-5x"></i>
<img src="..." class="rounded float-start" alt="..."></div>
        
        <div class="col-md-4">
            <label>First Name</label>
            <p>{{$instructorDetails['firstname']}}</p>
          </div>
          <div class="col-md-4">
            <label>Last Name</label>
            <p>{{$instructorDetails['lastname']}}</p>
          </div>
          <div class="col-12">
            <label>Email id</label>
            <p>{{$instructorDetails['instructor_email']}}</p>
          </div>
          <div class="col-12">
            <label>Assigned courses</label>
            <ul>
                @foreach($assigned_courses as $assigned_course)
                <li>{{ $assigned_course->course_title }}</li>
                @endforeach
            </ul>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <a class="btn btn-outline-secondary" href="{{route('manage-instructors')}}">Cancel</a>
            <a class="btn btn-primary" href="{{route('edit-instructor', ['instructor_id' => $instructorDetails['instructor_id']])}}">Edit instructor</a>
          </div>
          </section>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
