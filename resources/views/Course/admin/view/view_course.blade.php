@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
  <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Course.admin.view.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        @csrf
        <section class="row g-3 llp-view">
        <div class="py-4"><h3>Course Overview</h3><hr class="my-4"></div>
          <div class="col-12">
            <label>Title</label>
            <p>{{$course_details['title']}}</p>
          </div>
          <div class="col-12">
            <label>Description</label>
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
            <label>Duration</label>
            <p>{{$course_details['title']}}</p>
          </div>
          <div class="col-12">
            <label>What you'll learn</label>
            <p>{{$course_details['whatlearn']}}</p>
          </div>
          <div class="col-12">
            <label>Who this course is for?</label>
            <p>{{$course_details['whothis']}}</p>
          </div>
          <div class="col-12">
            <label>Course image</label>
            <img src="{{ asset('storage/courseImages/'.$course_details['image']) }}" alt="">
          </div>
          <div class="col-12">
            <label>Course thumbnail image</label>
            <img src="{{ asset('storage/courseImages/'.$course_details['thumbnail']) }}" alt="">
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
            <a class="btn btn-primary" href="{{route('edit-course', ['course_id' => $course_id])}}">Edit course</a>
          </div>
          </section>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->


<script>
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
