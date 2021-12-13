@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
  <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Course.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        
        <form action="{{ route('save-course') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        @csrf
        <input type="hidden" id="what_learn_points_count" name="what_learn_points_count">
        <input type="hidden" id="who_learn_points_count" name="who_learn_points_count">

          <div class="py-4">
          <h3>Course Overview</h3>
          <hr class="my-4">
        </div>
          <div class="col-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="course_title">
          </div>
          <div class="col-12">
            <label for="description">Description</label>
            <textarea type="text" class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="col-md-6">
            <label for="category">Category</label>
            <!-- <input type="text" class="form-control" id="category"> -->
            <select type="text" class="form-select" id="course_category" name="course_category">
            @foreach ($courseCategories as $courseCategory)
              <option value="{{$courseCategory->id}}">{{$courseCategory->category_name}}</option>
            @endforeach
          
            </select>
          </div>
          <div class="col-md-6">
            <label for="level">Level</label>
            <select type="text" class="form-select" id="course_difficulty" name="course_difficulty">
              <option value ="Beginner">Beginner</option>
              <option value ="Intermediate">Intermediate</option>
              <option value ="Advanced">Advanced</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="instructor-name">Instructor name</label>
            <select type="text" class="form-select" id="indtructor_name" name="instructor_name">
            @foreach ($instructors as $instructor)
              <option value ="{{$instructor->id}}">{{$instructor->firstname}} {{$instructor->lastname}}</option>
            @endforeach
          
            </select>
            <!-- <input type="text" class="form-control" id="instructor-name" name="instructor_name"> -->
          </div>
          <div class="col-md-6">
            <label for="duration">Duration</label>
            <input type="number" class="form-control" id="duration" name="course_duration" value="1">
          </div>
          <div class="col-12">
            <label for="what-learn">What you'll learn</label>
            <input type="text" class="form-control" id="what-learn" name="what_learn_1">
            <div id="add-more-points"></div>
            <button type="button" class="btn btn-secondary btn-sm mt-3" id="add-more-what-learn">Add more answer</button>
          </div>
          <div class="col-12">
            <label for="who-course">Who this course is for?</label><br>
            
            <label for="who-course-description">Description</label>
            <textarea class="form-control mb-3" id="who_learn_description" name="who_learn_description" rows="4" maxlength ="60"></textarea>
            
            <label for="who-course-description">Points</label>
            <input type="text" class="form-control" id="who_learn_points" name="who_learn_points_1">
            <div id="add-points"></div>
            
            <button type="button" class="btn btn-secondary btn-sm mt-3" id="add-more-who-learn">Add more answer</button>
          </div>
          <div class="col-12">
            <label for="course-image">Course image</label>
            <div class="row">
              <div class="col"><img src="{{ asset('storage/images/placeholder.jpg') }}" class="img-thumbnail" alt="..."></div>
              <div class="col">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed </p>
                <p>Lorem ipsum dolor sit amet,</p>
              </div>
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control" id="course-image" name="course_image">
              <label class="input-group-text" for="course-image">Upload</label>
            </div>
            </div>
          </div>
          <div class="col-12">
            <label for="course-thumbnail-image">Course thumbnail image</label>
            <div class="row">
              <div class="col"><img src="{{ asset('storage/images/placeholder.jpg') }}" class="img-thumbnail" alt="..."></div>
              <div class="col">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed </p>
                <p>Lorem ipsum dolor sit amet,</p>
              </div>
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control" id="course-thumbnail-image" name="course_thumbnail_image">
              <label class="input-group-text" for="course-thumbnail-image">Upload</label>
            </div>
            </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <!-- <button class="btn btn-primary" id="save_course" type="submit">Save as draft & continue</button> -->
          <input class="btn btn-primary" id="save_course" type="submit" value="Save as draft & continue">
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
