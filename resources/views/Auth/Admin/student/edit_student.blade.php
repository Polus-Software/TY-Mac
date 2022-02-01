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
      <form  class="form"  id="editStudentsForm" action="{{ route('update-student', ['student_id' => $studentDetails['id']])}}" method="POST">
        @csrf

        <section class="row g-3 llp-view">
        <div class="py-4"><h3 class="titles">Student details</h3></div>
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
            <label>Reset Password<i class="far fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="This filed is for reseting the existing password."></i></label>
            <input type="password" class="form-control" value="" name="password" id="student_password" placeholder="Enter new password">
            <span><i class="fas fa-eye-slash" id="adminTogglePass" onClick="adminViewPassword()"></i></span>
            <button type="button" class="btn btn-link shadow-non text-decoration-none text-secondary" id="generate_password">Generate password</button>
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
	<div class="col-1"></div>
  </div>
</div>
@endsection('content')
@push('child-scripts')
  <script>
  function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!-?';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }

  document.getElementById('generate_password').addEventListener('click', function(event) {
    document.getElementById('student_password').value = makeid(12);
  });
  function adminViewPassword()
  {
    let passwordInput = document.getElementById('student_password');
    if (passwordInput.type == 'password'){
      passwordInput.type='text';
      document.getElementById('adminTogglePass').className = 'fas fa-eye';
    }
    else{
      passwordInput.type='password';
      document.getElementById('adminTogglePass').className = 'fas fa-eye-slash';
    }

  }

</script>
<!-- container ends -->


<script src="{{ asset('assets/adminEdit.js') }}"></script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush
