@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')

<div class="container llp-container"> 
    <div class="row">

    <div class="col-2 position-fixed"> 
      <!-- include sidebar here -->
      @include('Course.admin.view.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
      <div class="py-4"><h5>Course Title: {{$course_title}}</h5><hr class="my-4"></div>
      <div class="py-4">
          <ul class="nav nav-tabs llp-tabs">
   <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="{{ route('view_cohortbatches', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">Assignment list</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('create-assignment', [ 'course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">New Assignment</a>
  </li> 
 </ul>
</div> 
    <div class="row">
          @foreach($assignments as $assignment)
          <div class="col-12 mb-3">
            <div class="card">
              <div class="card-header text-capitalize">
              Assignment : <strong>{{$assignment->assignment_title}}</strong>
              <!-- <span>20 minutes to complete</span> -->
              </div>
              <div class="card-body">
              <p class="card-text">{{$assignment->assignment_description}}</p>
              <!-- <a href="#" class="">Go somewhere</a> -->
              <div class="row">
              <div class="col-md-6">
              <label for=""><strong>Topic:</strong></label>
              <p>{{$assignment->topic_title}}</p>

              </div>
              <div class="d-flex align-items-end col-md-6">
              <a class="btn btn-sm btn-outline-dark me-3" href="{{ route('edit-assignment', ['assignment_id' => $assignment->id,'course_id' => $course_id ]) }}">Edit</a>
              <a class="btn btn-sm btn-outline-dark me-3" href="{{ route('delete-assignment', ['assignment_id' => $assignment->id]) }}">Delete</a>
              </div>
              </div>

              </div>
            </div>
          </div>
          @endforeach
        </div>
      </main>
    </div>
</div>
@endsection('content')



