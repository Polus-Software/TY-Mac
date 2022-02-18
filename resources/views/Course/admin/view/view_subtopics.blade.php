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
      <div class="py-4"><h5 class="titles">Course Title: {{$course_title}}</h5></div>
      <div class="py-4">
          <ul class="nav nav-tabs llp-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="{{ route('view-subtopics', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">Topics List</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('create-subtopic', ['course_id' => $course_id]) }}" style="text-decoration:none; color:inherit;">New Topic</a>
  </li>
</ul>
        </div>

        <div class="row">
         
          <div class="col-12 mb-3">
            <div class="card">
              <h5 class="card-title ms-3 mt-3 pb-2 border-bottom">
             <strong>Topics</strong>
              </h5>
              <div class="card-body">
              @php ($slno = 0)
                @forelse($courseContents as $courseContent)
                @php ($slno = $slno + 1)
                <ul class="list-group list-group-flush border-bottom pb-3">
                
                <h6 class="card-subtitle mb-3 mt-3"> Session {{$slno}} - {{$courseContent['topic_title']}}</h6>
                
                    @foreach($courseContent['contentsData'] as $content)
                        <li class="ms-4 border-0 pb-2" style="list-style:circle;" id="{{$content['topic_content_id']}}">{{$content['topic_title']}}</li>
                    @endforeach
                    <div class="d-flex justify-content-end mb-4">
                     
                      <a class="btn btn-sm btn-outline-dark me-2" href="{{ route('edit-subtopics', ['topic' => $courseContent['topic_id']]) }}">Edit</a>
                      <a class="btn btn-sm btn-outline-dark" href="{{ route('delete-subtopics', ['topic' => $courseContent['topic_id']]) }}">Delete</a>
                    </div>
                </ul>
              @empty
              <x-nodatafound message="No data to show!"  notype=""/>  
              @endforelse 
             
              </div>
              
              </div>

              </div>
            </div>
            

          </div>
			<div class="col-1"></div>
        </div>
      </main>
      <!-- main ends -->
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
