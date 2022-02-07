@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<input type="hidden" id="course_id" value="{{ $course_id }}" />
<div class="container-fluid llp-container">
  <div class="row">
  <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Course.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        @csrf
        <section class="row g-3 llp-view">
        <div class="py-4"><h3 class="titles">Course Overview</h3></div>
          <div class="col-12">
            <label>Course Title</label>
            <p>{{$course_details['title']}}</p>
          </div>
          <div class="col-12">
            <label>Course Description</label>
            <p>{{$course_details['description']}}</p>
          </div>
          <div class="col-md-6">
            <label>Category</label>
            <p>{{$course_details['category']}}</p>
          </div>
          <div class="col-md-6">
            <label>Level</label>
            <p>{{$course_details['difficulty']}}</p>
          </div>
          <div class="col-md-6">
            <label>Instructor name</label>
            <p>{{$course_details['instructor']}}</p>
          </div>
          <div class="col-md-6">
            <label>Class Duration in hours</label>
            <p>{{$course_details['duration']}} h</p>
          </div>
          <div class="col-12">
            <label>What you'll learn</label>
            <ul>
            @foreach($course_details['whatlearn'] as $whatlearn)
            <li>{{$whatlearn}}</li>
            @endforeach
            </ul>
          </div>
          <div class="col-12">
            <label>Who is this course is for?</label>
            <p>
            @foreach($course_details['whothis'] as $whothis)
            @if($whothis != '')
            {{$whothis}}
            @endif
            @endforeach
            </p>
          </div>
          <div class="col-12">
            <label>Course image</label>
            <div style="margin-top:15px;">
                <img src="{{ asset('/storage/courseImages/'.$course_details['image']) }}" alt="" style="width:320px; height:240px;">
            </div>
          </div>
          <div class="col-12">
            <label>Course thumbnail image</label>
            <div style="margin-top:15px;">
                <img src="{{ asset('/storage/courseThumbnailImages/'.$course_details['thumbnail']) }}" alt="" style="width:500px; height:300px;">
            </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
            <a id="edit_course" style="" class="btn btn-primary" href="{{route('edit-course', ['course_id' => $course_id])}}">Edit course</a>
          </div>
          </section>
      </main>
    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->


<script>
  if(document.getElementById('publish').innerHTML == "Unpublish") {
    document.getElementById('edit_course').style.display = "none";
  } else {
    document.getElementById('edit_course').style.display = "block";
  }
  
  // let coursePoint = 2;
  // let descPoint = 2;
  // document.getElementById('add-more-who-learn').addEventListener('click', (event) =>{

  // var input = document.createElement("INPUT");
  // input.setAttribute("name", "who_learn_points_" + coursePoint);
  // document.getElementById('who_learn_points_count').value = coursePoint;
  // coursePoint++;
  // document.getElementById("add-points").appendChild(input);
   
  // });

  // document.getElementById('add-more-what-learn').addEventListener('click', (event) =>{

  // var inputElement = document.createElement("INPUT");
  // inputElement.setAttribute("name", "what_learn_" + descPoint);
  // document.getElementById('what_learn_points_count').value = descPoint;
  // descPoint++;
  // document.getElementById("add-more-points").appendChild(inputElement);

   
  // });
</script>
@endsection('content')
