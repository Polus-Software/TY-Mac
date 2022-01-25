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
      @php
      $pagename = Route::current()->getName();
      $isEdit = false;
      if($pagename === 'edit-admin') {
        $isEdit = true;
      } else {
       $isEdit = false;
      }
      @endphp
        @if(!!$isEdit)
        <form class="form" id="editAdminForm" action="{{ route('update-admin', ['admin_id' => $adminDetails['admin_id']])}}" method="POST">
          <input type="hidden" id="admin_id" name="admin_id" value="{{ $adminDetails['admin_id'] }}">
          @else
          <form class="form" id="createAdminDetailsForm" action="{{ route('save-admin')}}" method="POST">
            @endif
            @csrf

            <section class="row g-3 llp-view">
              <div class="py-4">
                <h3>{{ (!!$isEdit) ? 'Edit profile' : 'Add Admin' }}</h3>
                <hr class="my-4">
              </div>
              <div class="col-md-6">
                <label>First Name</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$adminDetails['firstname']}}" name="firstname" id="firstname" placeholder="Enter First Name">
                @else
                <input type="text" class="form-control" value="" name="firstname" id="firstname" placeholder="Enter First Name">
                @endif
                @if ($errors->has('firstname'))
                <div class="invalid-feedback d-block">{{ $errors->first('firstname') }}</div>
                @endif
              </div>
              <div class="col-md-6">
                <label>Last Name</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$adminDetails['lastname']}}" name="lastname" id="lastname" placeholder="Enter Last Name">
                @else
                <input type="text" class="form-control" value="" name="lastname" id="lastname" placeholder="Enter Last Name">
                @endif
                @if ($errors->has('lastname'))
                <div class="invalid-feedback d-block">{{ $errors->first('lastname') }}</div>
                @endif
              </div>
              <div class="col-12">
                <label>Email id</label>
                @if(!!$isEdit)
                <input type="email" class="form-control" value="{{$adminDetails['email']}}" name="email" id="email" placeholder=" Enter email">
                @else
                <input type="email" class="form-control" value="" name="email" id="email" placeholder=" Enter email">
                @endif
                @if ($errors->has('email'))
                <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                @endif
              </div>
              @if(!$isEdit)
              <div class="col-12">
                <label for="admin_password" class="col-form-label">Password<i class="far fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="This filed is for creating a new password."></i></label>
                <input type="password" class="form-control has-validation" id="admin_password" name="password"></input>
                <span><i class="fas fa-eye-slash" id="adminTogglePass" onClick="adminViewPassword()"></i></span>
                <button type="button" class="btn btn-link text-secondary text-decoration-none shadow-none" id="generate_password">Generate password</button>
                @else
                <div class="col-12"> 
                <label>Reset Password<i class="far fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="This filed is for reseting the existing password."></i></label>
                <input type="password" class="form-control has-validation"  name="password" id="admin_password" placeholder="Enter password">
                <span><i class="fas fa-eye-slash" id="adminTogglePass" onClick="adminViewPassword()"></i></span>
                <button type="button" class="btn btn-link text-secondary text-decoration-none shadow-none" id="generate_password">Generate password</button>
            </div>
                @endif
                  @if ($errors->has('password'))
                  <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                  @endif
              </div>
          
              <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5 mt-4">
                <a class="btn btn-outline-secondary" href="{{route('manage-admin')}}">Cancel</a>                
                  @if(Route::current()->getName() == 'edit-admin')
                  <button type="submit" class="btn btn-primary btn-dark">Update</button>
                  @else
                  <button type="submit" class="btn btn-primary">Save</button>
                  @endif
              </div>
            </section>
          </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
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
    document.getElementById('admin_password').value = makeid(12);
    
  });
  function adminViewPassword()
  {
    let passwordInput = document.getElementById('admin_password');
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
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endpush