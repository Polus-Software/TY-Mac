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
      <div class="py-4">
          <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="{{ route('view-assignment') }}">Assignment list</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('create-assignment') }}">New Assignment</a>
  </li>
</ul>
        </div>

        <div class="row">
            <div class="col-12">
            <div class="card">
  <div class="card-header">
    Assignemnt: Assignemnt1
    <span>20 minutes to complete</span>
  </div>
  <div class="card-body">
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="">Go somewhere</a>
    <div class="row">
    <div class="col-md-6">
            <label for="choose-sub-topic">Choose sub topic</label>
            <select type="text" class="form-select" id="choose-sub-topic">
            <option selected>Select...</option>
            </select>
            
          </div>
          <div class="d-flex align-items-end col-md-6">
          <button class="btn btn-sm btn-outline-dark me-3" type="button">Edit</button>
          <button class="btn btn-sm btn-outline-dark" type="button">Delete</button>
          </div>
          </div>
          
  </div>
</div>
            </div>
        </div>
      </main>
      <!-- main ends -->
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
