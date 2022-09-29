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
        <div class="py-4"><h3 class="titles">Student details</h3></div>
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
            @if(count($enrolled_courses) != 0)
            <ul>              
                @foreach($enrolled_courses as $enrolled_course)
                <li>{{ $enrolled_course['enrolled_course']->course_title }} (Batch: {{ $enrolled_course['batch'] }})</li>
                @endforeach              
            </ul>
            @else
                <p>No data</p>
              @endif
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <a class="btn think-btn-secondary-outline" href="{{route('admin.viewall')}}">Cancel</a>
            <a class="btn btn-secondary think-btn-secondary" href="{{route('edit-student', ['student_id' => $student_id])}}">Edit student</a>
          </div>
          </section>
      </main>
    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
