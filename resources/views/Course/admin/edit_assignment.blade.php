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
      <form class="row g-3 llp-form" action="{{ route('update-assignment') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <input type="hidden" id="course_id" name="course_id" value="{{$assignment_details['course_id']}}">
      <input type="hidden" id="course_id" name="assignment_id" value="{{$assignment_details['id']}}">
      <div class="py-4">
          <ul class="nav nav-tabs llp-tabs">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="{{ route('view-assignments', ['course_id' => $assignment_details['course_id']] ) }}" style="text-decoration:none; color:inherit;">Assignment list</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('create-assignment', [ 'course_id' => $assignment_details['course_id']]) }}" style="text-decoration:none; color:inherit;">New Assignment</a>
            </li> 
          </ul>
      </div> 
        <div class="col-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="assignment_title" value="{{$assignment_details['assignment_title']}}">
          </div>
          <div class="col-12">
            <label for="description">Assignment</label>
            <textarea type="text" class="form-control" id="description" name="assignment_description">{{$assignment_details['assignment_description']}}</textarea>
          </div>
          <div class="row bd-highlight pt-3">
          <div class="col-11">
          <label>Attach file</label>  
          <input type="file" class="form-control mb-3" id="document" name="document" placeholder="Upload from device" value="{{$assignment_details['document']}}">
          <small class="fst-italic">Supported File Formats are:  ppt, pdf, doc, docx</small><br>
          <!-- <input type="file" class="form-control" id="document" name="document"> -->
          <!-- <a href="" class="btn btn-sm btn-outline-dark"></a> -->
          <!-- <div class="vr me-2 ms-2"></div> -->
          <div id="external-link-div" class="mt-2" style="display:none;">
            <label>Add external link</label>
            <input class="form-control" type="text" id="external-link" name="external-link" /><i id="close-ext" class="fas fa-trash-alt mt-2"></i>
          </div>
          <a style="margin-top:10px;" id="add-ext-link-assign" href="#" class="btn btn-sm btn-outline-dark">Add external link</a>
          </div>
      </div>
    <!-- <div class="col-11">
    <label>Attach file</label>  
    <input type="file" class="form-control" id="document" name="document" placeholder="Upload from device">
    <div class="vr me-2 mt-2"></div>
    <a href="" class="btn btn-sm btn-outline-dark">Add external link</a>
    </div>
    <div class="col-1">
    <i class="fas fa-trash-alt"></i>
    </div>
  </div> -->
          <div class="col-md-6">
            <label for="choose-sub-topic">Choose sub topic</label>
            <select type="text" class="form-select" id="choose-sub-topic" name="assignment_topic_id">
            <option selected>Select...</option>
            @foreach ($subTopics as $subTopic)
            <option value="{{$subTopic->topic_id}}" {{ ($subTopic->topic_id == $assignment_details['topic_id']) ? 'selected' :''}}>{{$subTopic->topic_title}}</option>
            @endforeach
            </select>
            
          </div>
          <div class="col-md-6">
            <label for="due-date">Assignment due date</label>
            <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="due-date" id="due-date" aria-label="due-date"  name="due-date" aria-describedby="due-date-icon" value="{{$assignment_details['due_date']}}">
            <span class="input-group-text" id="due-date-icon"><i class="fas fa-calendar-alt"></i></span>
          </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" type="submit">Update assignment</button>
          </div>
      </form>
      </main>
      <!-- main ends -->
    </div>
    <div class="col-1"></div>
  </div>
</div>
<!-- container ends -->


@endsection('content')
<link rel="stylesheet" href="{{ asset('/assets/dtsel.css') }}">
<script type="text/javascript" src="{{ asset('/assets/dtsel.js') }}"></script>
  
<script>
  window.onload = function(){
    startdate = new dtsel.DTS('input[name="due-date"]', {
    dateFormat: "mm-dd-yyyy",
    paddingX: 15, paddingY: 15
  });
    document.getElementById('add-ext-link-assign').addEventListener('click', function(event) {
    event.preventDefault();
      document.getElementById("external-link-div").style.display = "block";
  });
  document.getElementById('close-ext').addEventListener('click', function(event) {
    event.preventDefault();
      document.getElementById("external-link-div").style.display = "none";
  });
  };
  
</script>

