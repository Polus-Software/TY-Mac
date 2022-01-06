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
      if($pagename === 'edit-instructor') {
        $isEdit = true;
      } else {
       $isEdit = false;
      }
      @endphp
        @if(!!$isEdit)
        <form class="form" id="editInstructorForm" action="{{ route('update-instructor', ['instructor_id' => $instructorDetails['instructor_id']])}}" method="POST" enctype="multipart/form-data">
          <input type="hidden" id="instructor_id" name="instructor_id" value="{{ $instructorDetails['instructor_id'] }}">
          @else
          <form class="form" id="createInstructorForm" action="{{ route('save-instructor')}}" method="POST" enctype="multipart/form-data">
            @endif
            @csrf

            <section class="row g-3 llp-view">
              <div class="py-4">
                <h3>{{ (!!$isEdit) ? 'Edit profile' : 'Add Instructor' }}</h3>
                <hr class="my-4">
              </div>
              <div class="col-md-6">
                <label>First Name</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$instructorDetails['firstname']}}" name="firstname" id="firstname" placeholder="Enter First Name">
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
                <input type="text" class="form-control" value="{{$instructorDetails['lastname']}}" name="lastname" id="lastname" placeholder="Enter Last Name">
                @else
                <input type="text" class="form-control" value="" name="lastname" id="lastname" placeholder="Enter Last Name">
                @endif
                @if ($errors->has('lastname'))
                <div class="invalid-feedback d-block">{{ $errors->first('lastname') }}</div>
                @endif
              </div>
              
              <div class="col-md-6">
                <label>Email Id</label>
                @if(!!$isEdit)
                <input type="email" class="form-control" value="{{$instructorDetails['instructor_email']}}" name="email" id="email" placeholder=" Enter email">
                @else
                <input type="email" class="form-control" value="" name="email" id="email" placeholder=" Enter email">
                @endif
                @if ($errors->has('email'))
                <div class="invalid-feedback d-block">{{ $errors->first('email') }}</div>
                @endif
              </div>
              <div class="col-md-6">
                <label for="institute">Institute</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$instructorDetails['instructor_institute']}}" name="institute" id="institute" placeholder="Enter institute">
                @else
                <input type="text" class="form-control" name="institute" id="institute" placeholder="Enter institute">
                @endif
                @if ($errors->has('institute'))
                <div class="invalid-feedback d-block">{{ $errors->first('institute') }}</div>
                @endif
              </div>

              <div class="col-md-6">
                <label for="designation">Designation</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$instructorDetails['instructor_designation']}}" name="designation" id="designation" placeholder="Enter designation">
                @else
                <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter designation">
                @endif
                @if ($errors->has('designation'))
                <div class="invalid-feedback d-block">{{ $errors->first('designation') }}</div>
                @endif
              </div>

              <div class="col-md-6">
                <label for="twitter-link">Twitter Link</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$instructorDetails['instructor_twitter_social']}}" name="twitter_social" id="twitter_social" placeholder="Enter twitter link">
                @else
                <input type="text" class="form-control" name="twitter_social" id="twitter_social" placeholder="Enter twitter link">
                @endif
                @if ($errors->has('twitter_social'))
                <div class="invalid-feedback d-block">{{ $errors->first('twitter_social') }}</div>
                @endif
              </div>

              <div class="col-md-6">
                <label for="linkedin-link">LinkedIn Link</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$instructorDetails['instructor_linkedin_social']}}" name="linkedin_social" id="linkedin_social" placeholder="Enter linkedin link">
                @else
                <input type="text" class="form-control" name="linkedin_social" id="linkedin_social" placeholder="Enter linkedin link">
                @endif
                @if ($errors->has('linkedin_social'))
                <div class="invalid-feedback d-block">{{ $errors->first('linkedin_social') }}</div>
                @endif
              </div>

              <div class="col-md-6">
                <label for="youtube-link">Youtube Link</label>
                @if(!!$isEdit)
                <input type="text" class="form-control" value="{{$instructorDetails['instructor_youtube_social']}}" name="youtube_social" id="youtube_social" placeholder="Enter youtube link">
                @else
                <input type="text" class="form-control" name="youtube_social" id="youtube_social" placeholder="Enter youtube link">
                @endif
                @if ($errors->has('youtube_social'))
                <div class="invalid-feedback d-block">{{ $errors->first('youtube_social') }}</div>
                @endif
              </div>
              <div class="col-md-12">
                <label for="about">About</label>
                @if(!!$isEdit)
                <textarea class="form-control" value="{{$instructorDetails['instructor_description']}}" name="description" id="description" placeholder="Enter description" cols="30" rows="5"></textarea>
                @else
                <textarea class="form-control"  name="description" id="designation" placeholder="Enter description" cols="30" rows="5"></textarea>
                @endif
                @if ($errors->has('description'))
                <div class="invalid-feedback d-block">{{ $errors->first('description') }}</div>
                @endif
              </div>
              <div class="col-md-12">
                <label for="about">Signature</label>
                @if(!!$isEdit)
                <input class="form-control" type="file" value="" name="signature" id="signature" placeholder="Enter signature">
                @else
                <input class="form-control" type="file" name="signature" id="signature" placeholder="Enter signature">
                @endif
                @if ($errors->has('signature'))
                <div class="invalid-feedback d-block">{{ $errors->first('signature') }}</div>
                @endif
              </div>
              @if(!$isEdit)
                <div class="col-12">
                  <label for="instructor_password" class="col-form-label">Password</label>
                  <input type="text" class="form-control has-validation" id="instructor_password" name="password"></input>
              
                  @if ($errors->has('password'))
                  <div class="invalid-feedback d-block">{{ $errors->first('password') }}</div>
                  @endif
                  <button type="button" class="btn btn-link" id="generate_password" style="text-decoration:none; color:inherit;">Generate password</button>
                </div>
              @endif
              @if(!!$isEdit)
              <div class="col-12">
                <label>Assigned courses</label>
                <ul>
                  @foreach($assigned_courses as $assigned_courses)
                  <li>{{ $assigned_courses->course_title }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
                <a class="btn btn-outline-secondary" href="{{route('manage-instructors')}}">Cancel</a>                
                  @if(Route::current()->getName() == 'edit-instructor')
                  <button type="submit" class="btn btn-primary">Update</button>
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
    document.getElementById('instructor_password').value = makeid(12);
  });
</script>
@endsection('content')