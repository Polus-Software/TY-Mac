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
      @php
      $pagename = Route::current()->getName();
      $isEdit = false;
      if($pagename === 'edit-creator') {
        $isEdit = true;
      } else {
       $isEdit = false;
      }
      @endphp
        @if(!!$isEdit)
        <form class="form" id="editCreatorForm" action="{{ route('update-creator', ['creator_id' => $creatorDetails['creator_id']])}}" method="POST">
          <input type="hidden" id="creator_id" name="creator_id" value="{{ $creatorDetails['creator_id'] }}">
          @else
          <form class="form" id="createCreatorDetailsForm" action="{{ route('save-creator')}}" method="POST">
            @endif
            @csrf

            <section class="row g-3 llp-view">
              <div class="py-4">
                <h3 class="titles">{{ (!!$isEdit) ? 'Edit profile' : 'Add Creator' }}</h3>
              </div>
              <div class="col-md-6">
                <label>First Name*</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$creatorDetails['firstname']}}" name="firstname" id="firstname" placeholder="Enter First Name">
                @else
                <input type="text" class="form-control" value="{{old('firstname')}}" name="firstname" id="firstname" placeholder="Enter First Name">
                @endif
                @if ($errors->has('firstname'))
                <div class="invalid-feedback d-block">{{ $errors->first('firstname') }}</div>
                @endif
              </div>
              <div class="col-md-6">
                <label>Last Name*</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$creatorDetails['lastname']}}" name="lastname" id="lastname" placeholder="Enter Last Name">
                @else
                <input type="text" class="form-control" value="{{old('lastname')}}" name="lastname" id="lastname" placeholder="Enter Last Name">
                @endif
                @if ($errors->has('lastname'))
                <div class="invalid-feedback d-block">{{ $errors->first('lastname') }}</div>
                @endif
              </div>
              <div class="col-12">
                <label>Email id*</label>
                @if(!!$isEdit)
                <input type="email" class="form-control" value="{{$creatorDetails['email']}}" name="email" id="email" placeholder=" Enter email">
                @else
                <input type="email" class="form-control" value="{{old('email')}}" name="email" id="email" placeholder=" Enter email">
                @endif
                @if ($errors->has('email'))
                <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                @endif
              </div>
              @if(!$isEdit)
              <div class="col-12">
                <label for="creator_password" class="col-form-label">Password*<i class="far fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="This filed is for creating a new password."></i></label>
                <input type="password" class="form-control has-validation" id="creator_password" name="password"></input>
                <span><i class="fas fa-eye-slash" id="adminTogglePass" onClick="adminViewPassword()"></i></span>
                <button type="button" class="btn btn-link shadow-none text-decoration-none text-secondary" id="generate_password">Generate password</button>
               
                @else
                <div class="col-12"> 
                <label>Reset Password<i class="far fa-question-circle text-muted ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="This filed is for reseting the existing password."></i></label>
                <input type="password" class="form-control" value="" name="password" id="creator_password" placeholder=" Enter password">
                <span><i class="fas fa-eye-slash" id="adminTogglePass" onClick="adminViewPassword()"></i></span>
                <button type="button" class="btn btn-link shadow-none text-decoration-none text-secondary" id="generate_password">Generate password</button>
              
                @endif
                  @if ($errors->has('password'))
                  <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                  @endif
              </div>
              @if(Route::current()->getName() == 'edit-creator')
				        <!--<div class="col-1"></div>-->
              @endif
              <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end mb-5 mt-4">
                <a class="btn btn-outline-secondary" href="{{route('manage-creators')}}">Cancel</a>                
                  @if(Route::current()->getName() == 'edit-creator')
                  <button type="submit" class="btn btn-primary btn-dark">Update</button>
                  @else
                  <button type="submit" class="btn btn-primary">Save</button>
                  @endif
              </div>
            </section>
          </form>
      </main>
  </div>
  
				        <div class="col-1"></div>
             
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
    document.getElementById('creator_password').value = makeid(12);
  });
  function adminViewPassword()
  {
    let passwordInput = document.getElementById('creator_password');
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