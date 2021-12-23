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
        <div class="py-4"><h3>Student details</h3><hr class="my-4"></div>
        <div class="col-md-6">
            <label>First Name</label>
            <p>{{$studentDetails['firstname']}}</p>
          </div>
          <div class="col-md-6">
            <label>Last Name</label>
            <p>{{$studentDetails['lastname']}}</p>
          </div>
          <div class="col-12">
            <label>Email id</label>
            <p>{{$studentDetails['email']}}</p>
          </div>
          <div class="col-12">
            <label>Enrolled courses</label>
            <ul>
                @foreach($enrolled_courses as $enrolled_course)
                <li>{{ $enrolled_course->course_title }}</li>
                @endforeach
            </ul>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <a class="btn btn-outline-secondary" href="{{route('admin.viewall')}}">Cancel</a>
            <a class="btn btn-primary" href="{{route('edit-student', ['student_id' => $student_id])}}">Edit student</a>
          </div>
          </section>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
