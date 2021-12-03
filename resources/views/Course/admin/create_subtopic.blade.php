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
            <h4>Course Title:<span>Lorem ipsum dolor sit amet</span></h4>
            <hr class="my-4">
          </div>
          <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title">Enter subtopic title</h5>
                <input type="text" class="form-control" id="title">
                <div class="llpcard-inner bg-light mt-3 mb-3 p-3">
                  <!-- <input type="text" class="form-control" id="title"> -->
                  <!-- <div class="p-2 flex-fill bd-highlight">study material</div>
                  <div class="p-2 flex-fill bd-highlight"><a href="" class="btn btn-sm btn-outline-dark">Upload from device</a></div>
                  <div class="p-2 flex-fill bd-highlight"><a href="" class="btn btn-sm btn-outline-dark">Add external link</a></div>
                  <div class="p-2 flex-fill bd-highlight justify-content-end"><i class="fas fa-trash-alt"></i></div> -->
                <!-- <div class="row bd-highlight p-3">
                  <div class="col-11">
                    study material
                  <a href="" class="btn btn-sm btn-outline-dark">Upload from device</a>
                  <div class="vr me-2 ms-2"></div>
                  <a href="" class="btn btn-sm btn-outline-dark">Add external link</a>
                </div> -->
                <!-- <div class="col-1">
                  <i class="fas fa-trash-alt"></i>
                </div> -->
                <div class="row">
                  <div class="col-12">
                    <div class="collapse" id="addContentForSubTopic">
                      <div class="card card-body mb-3" id="collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <input type="text" class="form-control" id="content"> 
                      <div class="p-2 flex-fill bd-highlight row">
                       
                        <div class="col-lg-3"> study material:</div>
                        <div class="col-lg-6 col-12"><a href="" class="btn btn-sm btn-outline-secondary">Upload from device </a>
                        <a href="" class="btn btn-sm btn-outline-secondary">add external link</a></div>
                        <div class="col-lg-3 text-end"><a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"></a><i class="fas fa-trash-alt "></i></div>
                       
                      </div>
                      
                      </div>
                    </div>

                    <a class="btn btn-sm btn-outline-secondary" id="add_content_btn">Add content for sub-topic</a>
                    <a href="" class="btn btn-sm btn-outline-secondary">Upload audio/video</a>
                </div>
              </div>
          </div>
        </div>
      </div>
        <div class="row">
            <div class="col-12">
              <a href="" class="btn btn-sm btn-outline-secondary">Add a subtopic</a>
            </div>
      </div>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" type="button">Save</button>
          <span id="test_span"></span>
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
<script>
  window.onload = function(event) {
  document.getElementById('add_content_btn').addEventListener('click', function(event){
    var newItem = document.createElement("H1");
  var textnode = document.createTextNode("Water");
     newItem.appendChild(textnode);

     var testSpan = document.getElementById('test_span');
     testSpan.insertBefore(newItem, testSpan.childNodes[0]);
  });
}
  </script>