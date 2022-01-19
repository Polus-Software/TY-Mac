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
      <form  class="form"  id="editStudentsForm" action="{{ route('update-student', ['student_id' => $studentDetails['id']])}}" method="POST">
        @csrf

        <section class="row g-3 llp-view">
        <div class="py-4"><h3>Student details</h3><hr class="my-4"></div>
        <div class="col-md-6 mb-3">
            <label>First Name</label>
            <input type="text" class="form-control"  value ="{{$studentDetails['firstname']}}" name="firstname" id="firstname" placeholder="Enter First Name">
            <small class="small">Error message</small>  
            @if ($errors->has('firstname'))
                <span class="text-danger">{{ $errors->first('firstname') }}</span>
            @endif
          </div>
          <div class="col-md-6 mb-3">
            <label>Last Name</label>
            <input type="text" class="form-control" value="{{$studentDetails['lastname']}}" name="lastname" id="lastname" placeholder="Enter Last Name">
            <small class="small">Error message</small>  
            @if ($errors->has('lastname'))
                <span class="text-danger">{{ $errors->first('lastname') }}</span>
            @endif
          </div>
          <div class="col-12 mb-3">
            <label>Email id</label>
            <input type="email" class="form-control" value="{{$studentDetails['email']}}" name="email" id="email" placeholder=" Enter email">
            <small class="small">Error message</small>  
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
          </div>
          <div class="col-12 mb-3">
            <label>Password</label>
            <input type="password" class="form-control" value="" name="password" id="student_password" placeholder="Enter Password">
            <small class="small">Error message</small>  
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
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
          <button type="submit" class="btn btn-primary">Update</button>
          </div>
          </section>
      </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->


<script src="{{ asset('assets/adminEdit.js') }}"></script>
@endsection('content')
