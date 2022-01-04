@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
    <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Course.admin.create.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        @if(Route::current()->getName() == 'edit-course')
        <form action="{{ route('update-course') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        <input type="hidden" id="course_id" name="course_id" value="{{ $course_id}}">
        @else
        <form action="{{ route('save-course') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        @endif
        @csrf
        <input type="hidden" id="what_learn_points_count" name="what_learn_points_count">
        <input type="hidden" id="who_learn_points_count" name="who_learn_points_count">
          <div class="py-4"><h3>Course Overview</h3>
          <hr class="my-4">
        </div>
          <div class="col-12">
            <label for="title">Title</label>
            @if(isset($course_details['title']))
            <input type="text" class="form-control" id="title" name="course_title" value="{{ $course_details['title'] }}">
            @else
            <input type="text" class="form-control" id="title" name="course_title">
            @endif
          </div>
          <div class="col-12">
            <label for="description">Description</label>
            @if(isset($course_details['description']))
            <textarea type="text" class="form-control" id="description" name="description">{{ $course_details['description'] }}</textarea>
            @else
            <textarea type="text" class="form-control" id="description" name="description"></textarea>
            @endif
          </div>
          <div class="col-md-6">
            <label for="category">Category</label>
            <select type="text" class="form-select" id="course_category" name="course_category">
              <option value="">Select</option>
            @foreach ($courseCategories as $courseCategory)
            @if(isset($course_details['description']) && $courseCategory->id == $course_details['category_id'])
            <option value="{{$courseCategory->id}}" selected>{{ $courseCategory->category_name }}</option>
            @else
            <option value="{{$courseCategory->id}}">{{ $courseCategory->category_name }}</option>
            @endif                            
            @endforeach          
            </select>
          </div>
          <div class="col-md-6">
            <label for="level">Level</label>
            <select type="text" class="form-select" id="difficulty" name="difficulty">
              @if(isset($course_details['difficulty']) && $course_details['difficulty'] =='Beginner')
              <option value ="Beginner" selected>Beginner</option>
              @else
              <option value ="Beginner">Beginner</option>
              @endif
              @if(isset($course_details['difficulty']) && $course_details['difficulty'] =='Intermediate')
              <option value ="Intermediate" selected>Intermediate</option>
              @else
              <option value ="Intermediate">Intermediate</option>
              @endif
              @if(isset($course_details['difficulty']) && $course_details['difficulty'] =='Advanced')
              <option value ="Advanced" selected>Advanced</option>
              @else
              <option value ="Advanced">Advanced</option>
              @endif
            </select>
          </div>
          <div class="col-md-6">
            <label for="instructor-name">Instructor name</label>
            <select class="form-select" id="instructor" name="instructor">
            @foreach ($instructors as $instructor)
            @if(isset($course_details['instructor_id']) && $instructor->id == $course_details['instructor_id'])
            <option value ="{{ $instructor->id }}" selected>{{ $instructor->firstname }} {{ $instructor->lastname }}</option>
            @else
            <option value ="{{ $instructor->id }}">{{ $instructor->firstname }} {{ $instructor->lastname }}</option>
            @endif
            @endforeach          
            </select>
          </div>
          <div class="col-md-6">
            <label for="duration">Duration</label>            
            @if(isset($course_details['duration']))
            <input type="number" class="form-control" id="duration" name="course_duration" value="{{ $course_details['duration'] }}">
            @else
            <input type="number" class="form-control" id="duration" name="course_duration" value="1">
            @endif
          </div>
          <div class="col-12">
            <label for="what-learn">What you'll learn</label>            
            @if(isset($course_details['whatlearn']))
            <input type="text" class="form-control" id="what-learn" name="what_learn_1" value="{{ $course_details['whatlearn'] }}">
            @else
            <input type="text" class="form-control" id="what-learn" name="what_learn_1">
            @endif
            <div id="add-more-points"></div>
            <button type="button" class="btn btn-secondary btn-sm mt-3" id="add-more-what-learn">Add more answer</button>
          </div>
          <div class="col-12">
            <label for="who-course">Who this course is for?</label><br>
            
            <label for="who-course-description">Description</label>            
            @if(isset($course_details['whothis']))
            <textarea class="form-control mb-3" id="who_learn_description" name="who_learn_description" rows="4" maxlength ="60">{{ $course_details['whothis'] }}</textarea>
            @else
            <textarea class="form-control mb-3" id="who_learn_description" name="who_learn_description" rows="4" maxlength ="60"></textarea>
            @endif
            <label for="who-course-description">Points</label>
            @if(isset($course_details['whothis']))
            <input type="text" class="form-control" id="who_learn_points" name="who_learn_points_1" value="{{ $course_details['whothis'] }}">
            @else
            <input type="text" class="form-control" id="who_learn_points" name="who_learn_points_1">
            @endif            
            <div id="add-points"></div>            
            <button type="button" class="btn btn-secondary btn-sm mt-3" id="add-more-who-learn">Add more answer</button>
          </div>
          <div class="col-12">
            <label for="course-image">Course image</label>
            <div class="row">
              @if(isset($course_details['image']))
              <div class="col"><img src="{{ asset('storage/courseImages/'.$course_details['image']) }}" class="img-thumbnail" alt="..."></div>
              @else
              <div class="col"><img src="{{ asset('storage/images/placeholder.jpg') }}" class="img-thumbnail" alt="..."></div>
              <div class="col">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed </p>
                <p>Lorem ipsum dolor sit amet,</p>
              </div>
              @endif
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control" id="course-image" name="course_image">
              <label class="input-group-text" for="course-image">Upload</label>
            </div>
            </div>
          </div>
          <div class="col-12">
            <label for="course-thumbnail-image">Course thumbnail image</label>
            <div class="row">
            @if(isset($course_details['thumbnail']))
            <img src="{{ asset('storage/courseThumbnailImages/'.$course_details['thumbnail']) }}" alt="" style="width:500; height:400px;">
            @else
              <div class="col"><img src="{{ asset('storage/images/placeholder.jpg') }}" class="img-thumbnail" alt="..."></div>
              <div class="col">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed </p>
                <p>Lorem ipsum dolor sit amet,</p>
              </div>
              @endif
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control" id="course-thumbnail-image" name="course_thumbnail_image">
              <label class="input-group-text" for="course-thumbnail-image">Upload</label>
            </div>
            </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">          
          @if(Route::current()->getName() == 'edit-course')
          <a class="btn btn-outline-secondary" role="button" href="{{ route('view-course', ['course_id' => $course_id]) }}">Cancel</a>
          @else
          <a class="btn btn-outline-secondary" role="button" href="{{ route('manage-courses') }}">Cancel</a>
          @endif
          <button class="btn btn-primary" id="save_course" type="submit" value="Save as draft & continue">Save as draft & continue</button>
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->


<script>
  let coursePoint = 2;
  let descPoint = 2;
  document.getElementById('add-more-who-learn').addEventListener('click', (event) =>{

  var input = document.createElement("INPUT");
  input.setAttribute("name", "who_learn_points_" + coursePoint);
  document.getElementById('who_learn_points_count').value = coursePoint;
  coursePoint++;
  document.getElementById("add-points").appendChild(input);
   
  });

  document.getElementById('add-more-what-learn').addEventListener('click', (event) =>{

  var inputElement = document.createElement("INPUT");
  inputElement.setAttribute("name", "what_learn_" + descPoint);
  document.getElementById('what_learn_points_count').value = descPoint;
  descPoint++;
  document.getElementById("add-more-points").appendChild(inputElement);

   
  });
</script>
@endsection('content')
