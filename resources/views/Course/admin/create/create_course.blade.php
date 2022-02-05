@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
    <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Course.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        @if(Route::current()->getName() == 'edit-course')
        <input type="hidden" id="route_val" value="edit" />
        <form action="{{ route('update-course') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        <input type="hidden" id="course_id" name="course_id" value="{{ $course_id}}">
        <input type="hidden" id="what_learn_points_count" name="what_learn_points_count" value="{{ count($whatLearn) }}">
        <input type="hidden" id="who_learn_points_count" name="who_learn_points_count">
        @else
        <input type="hidden" id="route_val" value="new" />
        <form action="{{ route('save-course') }}" enctype="multipart/form-data" method="POST" class="row g-3 llp-form">
        <input type="hidden" id="what_learn_points_count" name="what_learn_points_count" value="1">
        <input type="hidden" id="who_learn_points_count" name="who_learn_points_count">
        @endif
        @csrf
          <div class="py-4"><h3 class="titles">Course Overview</h3>
        </div>
          <div class="col-12">
            <label for="title">Course Title</label>
            @if(isset($course_details['title']))
            <input type="text" class="form-control" id="title" name="course_title" value="{{ $course_details['title'] }}">
            @else
            <input type="text" class="form-control" id="title" name="course_title" placeholder="Ex: Fundamentals of Product Management" value="{{old('course_title')}}">
            @endif
            @if ($errors->has('course_title'))
              <span class="text-danger">{{ $errors->first('course_title') }}</span>
            @endif
          </div>
          <div class="col-12">
            <label for="description">Course Description</label>
            @if(isset($course_details['description']))
            <textarea type="text" class="form-control autosize" id="description" name="description">{{ $course_details['description'] }}</textarea>
            @else
            <textarea type="text" class="form-control autosize" id="description" name="description" placeholder="Product Management is the profession of building products. By taking this course, you will learn the fundamentals of Product Management">{{old('description')}}</textarea>
            @endif
            @if ($errors->has('description'))
              <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="category">Category</label>
            <select type="text" class="form-select" id="course_category" name="course_category">
            <option value="">Select</option>
            @foreach ($courseCategories as $courseCategory)
            
            @if(isset($course_details['description']) && $courseCategory->id == $course_details['category_id'])
            <option value="{{$courseCategory->id}}" selected>{{ $courseCategory->category_name }}</option>
            @elseif(old('course_category') == $courseCategory->id)
              <option value="{{$courseCategory->id}}" selected>{{ $courseCategory->category_name }}</option>
            @else
            <option value="{{$courseCategory->id}}">{{ $courseCategory->category_name }}</option>
            @endif                            
            @endforeach          
            </select>
            @if ($errors->has('course_category'))
              <span class="text-danger">{{ $errors->first('course_category') }}</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="level">Level</label>
            <select type="text" class="form-select" id="difficulty" name="difficulty">
              @if(isset($course_details['difficulty']) && $course_details['difficulty'] =='Beginner')
              <option value ="Beginner" selected>Beginner</option>
              @else
              <option value ="Beginner" {{ old('difficulty') == "Beginner" ? 'selected' : '' }}>Beginner</option>
              @endif
              @if(isset($course_details['difficulty']) && $course_details['difficulty'] =='Intermediate')
              <option value ="Intermediate" selected>Intermediate</option>
              @else
              <option value ="Intermediate" {{ old('difficulty') == "Intermediate" ? 'selected' : '' }}>Intermediate</option>
              @endif
              @if(isset($course_details['difficulty']) && $course_details['difficulty'] =='Advanced')
              <option value ="Advanced" selected>Advanced</option>
              @else
              <option value ="Advanced" {{ old('difficulty') == "Advanced" ? 'selected' : '' }}>Advanced</option>
              @endif
            </select>
            @if ($errors->has('difficulty'))
              <span class="text-danger">{{ $errors->first('difficulty') }}</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="instructor-name">Instructor name</label>
            <select class="form-select" id="instructor" name="instructor">
            @foreach ($instructors as $instructor)
            @if(isset($course_details['instructor_id']) && $instructor->id == $course_details['instructor_id'])
            <option value ="{{ $instructor->id }}" selected>{{ $instructor->firstname }} {{ $instructor->lastname }}</option>
            @else
            <option value ="{{ $instructor->id }}" {{ old('instructor') == "$instructor->id" ? 'selected' : '' }}>{{ $instructor->firstname }} {{ $instructor->lastname }}</option>
            @endif
            @endforeach          
            </select>
            @if ($errors->has('instructor'))
              <span class="text-danger">{{ $errors->first('instructor') }}</span>
            @endif
          </div>
          <div class="col-md-6">
            <label for="duration">Class Duration in hours</label>            
            @if(isset($course_details['duration']))
            <input type="number" class="form-control" id="duration" name="course_duration" value="{{ $course_details['duration'] }}">
            @else
            <input type="number" class="form-control" id="duration" name="course_duration" value="{{ old('course_duration') ? old('course_duration') : '1' }}">
            @endif
            @if ($errors->has('course_duration'))
              <span class="text-danger">{{ $errors->first('course_duration') }}</span>
            @endif
          </div>



          <div class="col-md-6">
            <label for="course-rating">Custom Rating</label>
            @if(isset($course_details['duration']))
            <select class="form-select" id="course_rating" name="course_rating" value="{{ $course_details['course_rating'] }}">
            @else
            <select class="form-select" id="course_rating" name="course_rating" value="">
            @endif
            @for ($i = 1; $i <= 5; $i++)
              <option value ="{{ $i }}" selected>{{ $i }}</option>
            @endfor         
            </select>
            @if ($errors->has('course_rating'))
              <span class="text-danger">{{ $errors->first('course_rating') }}</span>
            @endif
          </div>
          <div class="col-md-6" style="margin-top: 2.2rem;">
            @if(isset($course_details['use_custom_ratings']))
            @php 
                $checked = $course_details['use_custom_ratings'] ? 'checked' : ''; 
            @endphp
            <input type="checkbox" id="use_custom_ratings" name="use_custom_ratings" {{$checked}}>
            <label for="use_custom_ratings">Use custom ratings?</label> 
            @else
            <input type="checkbox" id="use_custom_ratings" name="use_custom_ratings">
            <label for="use_custom_ratings">Use custom ratings?</label> 
            @endif
          </div>


         
          <div class="col-12">
            <label for="what-learn">What you'll learn</label>            
            @if(isset($whatLearn))
            @php ($whatCount = 0)
            @foreach($whatLearn as $learn)
            @if($learn!='')
            @php ($whatCount = $whatCount + 1)
                <input type="text" class="form-control mt-2" id="what-learn" name="what_learn_{{ $whatCount }}" value="{{ $learn }}">
            @endif
            @endforeach
            @else
            <input type="text" class="form-control" id="what-learn" name="what_learn_1" value="{{old('what_learn_1')}}">
            @endif
            @if ($errors->has('what_learn_1'))
              <span class="text-danger">This field is required</span>
            @endif
            <div id="add-more-points"></div>
            <button type="button" class="btn btn-secondary btn-sm mt-3" id="add-more-what-learn">Add section</button>
          </div>
          <div class="col-12">
            <label for="who-course">Who is this course is for?</label><br>
            
            <!-- <label for="who-course-description">Description</label>            
            @if(isset($course_details['short_description']))
            <textarea class="form-control mb-3" id="who_learn_description" name="who_learn_description" rows="4">{{ $course_details['short_description'] }}</textarea>
            @else
            <textarea class="form-control mb-3" id="who_learn_description" name="who_learn_description" rows="4"></textarea>
            @endif

            @if ($errors->has('who_learn_description'))
              <span class="text-danger mb-3">This field is required</span><br>
            @endif -->
            
            <label for="who-course-points mt-2">Points</label>
            @if(isset($course_details['course_details_points']))
            <textarea class="form-control mb-3" name="who_learn_points" rows="4">{{ $course_details['course_details_points'] }}</textarea>
            @else
            <textarea class="form-control mb-3" name="who_learn_points" rows="4">{{old('who_learn_points')}}</textarea>
            @endif
            @if ($errors->has('who_learn_points'))
              <span class="text-danger mb-3">This field is required</span><br>
            @endif
          </div>
          <div class="col-12">
            <label>Course image</label>
            <div class="row">
              @if(isset($course_details['image']))
              <div class="col-4"><img src="{{ asset('storage/courseImages/'.$course_details['image']) }}" class="img-thumbnail no-image-border" alt="..."></div>
              @else
              <div class="col-4"><img src="{{ asset('storage/images/placeholder.png') }}" class="img-thumbnail no-image-border" alt="..."></div>
              <div class="col">
                <p>Important guidelines: <b>600x285</b> pixels</p>
                <p>Image must be less than <b>500kb</b> </p>
                <p> supported file formats: jpg, jpeg, png, .svg.</p>
              </div>
              @endif
            <div class="input-group mt-3 mb-3">
             
              <input type="file" class="form-control mb-2" id="course-image" name="course_image">

              <label class="input-group-text mb-2 left_right_padding" for="course-image">Upload Image</label>
            </div>
            @if ($errors->has('course_image'))
              <span class="text-danger">{{ $errors->first('course_image') }}</span>
            @endif   
            </div>
          </div>
          <div class="col-12">
            <label>Course thumbnail image</label>
            <div class="row">
            @if(isset($course_details['thumbnail']))
            <img src="{{ asset('storage/courseThumbnailImages/'.$course_details['thumbnail']) }}" alt="" style="width:500; height:400px;">
            @else
              <div class="col-4"><img src="{{ asset('storage/images/placeholder.png') }}" class="img-thumbnail no-image-border" alt="..."></div>
              <div class="col">
                <p>Important guidelines: <b>395x186 pixels</b></p>
                <p>Image must be less than <b>100kb</b> </p>
                <p> supported file formats: jpg, jpeg, png, .svg.</p>
              </div>
              @endif
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control mb-2" id="course-thumbnail-image" name="course_thumbnail_image">
              <label class="input-group-text mb-2 left_right_padding" for="course-thumbnail-image">Upload Image</label>
            </div>
            @if ($errors->has('course_thumbnail_image'))
              <span class="text-danger">This course thumbnail image field is required</span>
            @endif 
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
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->


<script>
  let coursePoint = 1;
  let descPoint = 1;
  if(document.getElementById('route_val').value == "edit") {
    let rating = document.getElementById('course_rating').getAttribute('value');
    document.getElementById('course_rating').value = rating;
  }
  if(document.getElementById('add-more-who-learn')){
    document.getElementById('add-more-who-learn').addEventListener('click', (event) =>{

    var input = document.createElement("INPUT");
    coursePoint++;
    input.setAttribute("name", "who_learn_points_" + coursePoint);
    document.getElementById('who_learn_points_count').value = coursePoint;
    document.getElementById("add-points").appendChild(input);
    
    });
  }
  if(document.getElementById('add-more-what-learn')){
  document.getElementById('add-more-what-learn').addEventListener('click', (event) =>{

  var inputElement = document.createElement("INPUT");
  descPoint++;
  inputElement.setAttribute("name", "what_learn_" + descPoint);
  document.getElementById('what_learn_points_count').value = descPoint;
  document.getElementById("add-more-points").appendChild(inputElement);

   
  });
  }


</script>
@endsection('content')
