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
        
        <form action="" class="row g-3 llp-form">
          <div class="py-4">
          <h3>Course Overview</h3>
          <hr class="my-4">
        </div>
          <div class="col-12">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title">
          </div>
          <div class="col-12">
            <label for="description">Description</label>
            <textarea type="text" class="form-control" id="description"></textarea>
          </div>
          <div class="col-md-6">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category">
          </div>
          <div class="col-md-6">
            <label for="level">Level</label>
            <select type="text" class="form-select" id="level">
            <option selected>Select...</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="instructor-name">Instructor name</label>
            <input type="text" class="form-control" id="instructor-name">
          </div>
          <div class="col-md-6">
            <label for="duration">Duration</label>
            <input type="text" class="form-control" id="duration">
          </div>
          <div class="col-12">
            <label for="what-learn">What you'll learn</label>
            <input type="text" class="form-control" id="what-learn">
            <button type="button" class="btn btn-secondary btn-sm mt-3">Add more answer</button>
          </div>
          <div class="col-12">
            <label for="who-course">Who this course is for?</label>
            <input type="text" class="form-control" id="who-course">
            <button type="button" class="btn btn-secondary btn-sm mt-3">Add more answer</button>
          </div>
          <div class="col-12">
            <label for="course-image">Course image</label>
            <div class="row">
              <div class="col"><img src="{{ URL::asset('assets/placeholder.jpg') }}" class="img-thumbnail" alt="..."></div>
              <div class="col">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed </p>
                <p>Lorem ipsum dolor sit amet,</p>
              </div>
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control" id="course-image">
              <label class="input-group-text" for="course-image">Upload</label>
            </div>
            </div>
          </div>
          <div class="col-12">
            <label for="course-thumbnail-image">Course thumbnail image</label>
            <div class="row">
              <div class="col"><img src="{{ URL::asset('assets/placeholder.jpg') }}" class="img-thumbnail" alt="..."></div>
              <div class="col">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed </p>
                <p>Lorem ipsum dolor sit amet,</p>
              </div>
            <div class="input-group mt-3 mb-3">
              <input type="file" class="form-control" id="course-thumbnail-image">
              <label class="input-group-text" for="course-thumbnail-image">Upload</label>
            </div>
            </div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" type="button">Save as draft & continue</button>
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
