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
        
        <form action="{{ route('add-sub-topic') }}" class="row g-3 llp-form" method="POST">
          @csrf
          <div class="py-4">
            <h4>Course Title:<span>Lorem ipsum dolor sit amet</span></h4>
            <hr class="my-4">
          </div>
          <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title">Enter subtopic title</h5>
                <input type="text" class="form-control" id="title" name="topic_title" placeholder="Ex: Session 1 - Intro to G Suite & Google Drive">
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
               
                <div id="add-content"></div>

                <div class="row">
                  <div class="col-12">
                    <div class="collapse" id="addContentForSubTopic">
                      <div class="card card-body mb-3">
                        <input type="text" class="form-control" id="content"> 
                      <!-- <div class="p-2 flex-fill bd-highlight row">
                       
                        <div class="col-lg-3"> study material:</div>
                        <div class="col-lg-6 col-12"><a href="" class="btn btn-sm btn-outline-secondary">Upload from device </a>
                        <a href="" class="btn btn-sm btn-outline-secondary">add external link</a></div>
                        <div class="col-lg-3 text-end"><a class="btn" href=""></a></div>
                       
                      </div> -->
                      
                      </div>
                    </div>

                    <a class="btn btn-sm btn-outline-secondary" id="add_content_btn">Add content for sub-topic</a>
                    <a class="btn btn-sm btn-outline-secondary" id="upload_audio_video">Upload audio/video</a>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
      
        </div>
      </div>
        <div class="row">
            <div class="col-12">
            <div id="add-sub-topic" class="mt-3"></div>
              <a class="btn btn-sm btn-outline-secondary" id="add_sub_topic_btn">Add a subtopic</a>
             
            </div>
      </div>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
          <button class="btn btn-primary" type="submit">Save</button>
          <!-- <span id="test_span"></span> -->
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
<!-- container ends -->
@endsection('content')
<script>
  let content_count = 1;
  let sub_topic_count = 1;

  // name-1-2;



  window.onload = function(event) {
  document.getElementById('add_content_btn').addEventListener('click', function(event){

    console.log(event);
  
   var div = document.createElement("DIV");
   div.setAttribute("id", "topicContent" + content_count);
   div.classList.add('card', 'card-body', 'mb-3');
   div.innerHTML = `<input type='text' class='form-control mb-3' id='content_" + content_count + 
   "' name='content-${content_count}-${sub_topic_count}' placeholder='Ex: What is Google Suite?'>
   <div id='add_external_link_field' class='add_external_link mb-3'></div>
   <div class='p-2 flex-fill bd-highlight row'>
   <div class='col-lg-3'> study material:</div>
   <div class='col-lg-5 col-12'><label>Upload from device</label>
   <input type='file'class='form-control' id='upload_sub_topic_content_${content_count}'
   name='upload_sub_topic_content-${content_count}-${sub_topic_count}' class='btn btn-sm btn-outline-secondary'></div>
   <div class='col-lg-3 pt-4'><a id='add_external_link_${content_count}'
   class='btn btn-sm btn-outline-secondary' name='external-link-${content_count}-${sub_topic_count}'>add external link</a></div>
   <div class='col-lg-1 text-end'><a id='remove-content_${content_count}' aria-label="" 
   content-number='${content_count}'><i class='fas fa-trash-alt'></i></a></div>
   </div></div>`;
   document.getElementById("add-content").appendChild(div);
   

   document.getElementById(`add_external_link_${content_count}`).addEventListener('click', function(event){
    var div_2 = document.createElement("DIV");
    div_2.innerHTML = `<div class='row'><div class='col-lg-4'>
                      <label>Add External Link</label></div>
                      <div class='col-lg-8'><input type='link' class='form-control' name='add_external_link_${content_count}'>
                      </div>`;
   
                      //document.getElementById(`add_external_link_field`).appendChild(div_2);
//event.target.parentNode.add_external_link_field.append(div_2);
   var closest = this.closest('#add-content').querySelector('.add_external_link');
   console.log(closest);
   //console.log(closest);
  closest.appendChild(div_2);
  // div_2.setAttribute("name", "add_external_link" + content_count);
    

   });



   let removeDiv = document.getElementById(`remove-content_${content_count}`);
   removeDiv.addEventListener('click', function(event){
     console.log(removeDiv);
    const topicNumber = removeDiv.getAttribute('content-number');
    console.log(topicNumber);
    document.getElementById('topicContent' + topicNumber).remove();
    console.log(event);
   });
   content_count++;
  });

  document.getElementById('add_sub_topic_btn').addEventListener('click', function(event){
    var div_3 = document.createElement("DIV");
    // div_3.setAttribute("id", "topicContent" + content_count);
    //div_3.classList.add('card', 'card-body', 'mb-3');
    div_3.innerHTML = `<div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title">Enter subtopic title</h5>
                <input type="text" class="form-control" id="title" name="topic_title" placeholder="Ex: Session 1 - Intro to G Suite &amp; Google Drive">
                <div class="llpcard-inner bg-light mt-3 mb-3 p-3">
                <div id="add-content" class="add_content_${content_count}"></div>
                <div class="row">
                  <div class="col-12">
                    <div class="collapse" id="addContentForSubTopic">
                      <div class="card card-body mb-3">
                        <input type="text" class="form-control" id="content"> 
                      </div>
                    </div>
                    <div class="row">
                    </div>
          
                    <a class="btn btn-sm btn-outline-secondary" id="add_content_btn">Add content for sub-topic</a>
                    <a class="btn btn-sm btn-outline-secondary" id="upload_audio_video">Upload audio/video</a>
                    <a id='remove-content_${content_count}' aria-label="" class="text-end"
                  content-number='${content_count}'><i class='fas fa-trash-alt'></i></a>
                </div>
              </div>
          </div>
        </div>
      </div>`;
   document.getElementById("add-sub-topic").appendChild(div_3);
});
   
  }
  
  
  </script>


