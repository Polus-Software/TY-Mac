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
      <form class="row g-3 llp-form" action="{{ route('update-assignment') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <input type="hidden" id="course_id" name="course_id" value="{{$course_id}}">
      <input type="hidden" id="course_id" name="assignment_id" value="{{$assignment_details['id']}}">
          <div class="py-4">
          <ul class="nav nav-tabs llp-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="{{ route('view-assignment') }}">Assignment list</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('create-assignment') }}">New Assignment</a>
  </li>
</ul>
        </div>
        <div class="col-12">
            <label for="title">Title({{$course_id}})</label>
            <input type="text" class="form-control" id="title" name="assignment_title" value="{{$assignment_details['assignment_title']}}">
          </div>
          <div class="col-12">
            <label for="description">Assignment</label>
            <textarea type="text" class="form-control" id="description" name="assignment_description">{{$assignment_details['assignment_description']}}</textarea>
          </div>
          <div class="row bd-highlight p-3">
    <div class="col-11">
    Attach file
    <a href="" class="btn btn-sm btn-outline-dark">Upload from device</a>
    <div class="vr me-2 ms-2"></div>
    <a href="" class="btn btn-sm btn-outline-dark">Add external link</a>
    </div>
    <div class="col-1">
    <i class="fas fa-trash-alt"></i>
    </div>
  </div>
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
  <input type="text" class="form-control" placeholder="due-date" id="due-date" aria-label="due-date" aria-describedby="due-date-icon">
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
  </div>
</div>
<!-- container ends -->
@endsection('content')
