@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- add assignment modal -->
<div id="add_assignmnent_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add an assignment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="POST" action="{{ route('add-assignment') }}">
          @csrf
          
          <div class="mb-3">
              <input type="hidden" id="assignment_topic_id" name="assignment_topic_id">
            <label for="assignment_title" class="col-form-label">Assignment Title</label>
            <input type="text" class="form-control" id="assignment_title" name="assignment_title">
            <small>Error message</small>
          </div>
          
          <div class="mb-3">
            <label for="assignment_description" class="col-form-label">Assignment Description</label>
            <textarea class="form-control" id="assignment_description" name="assignment_description"></textarea>
            <small>Error message</small>
          </div>
          <div class="mb-3">
            <label for="attachments" class="col-form-label">Upload Attachment (if any)</label>
            <input type="file" name="assignment_attachments" id="assignment_attachments">
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="add_assignment" class="btn btn-primary">Add assignment</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- assignment modal end -->

<div class="container">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="row mb-3 mt-5">
                <div class="col-4">
                <a href="{{ route('manage-courses') }}" class="btn btn-outline-secondary ">Back</a>
                </div>
            </div>
        <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Topic Title</th>
                <th scope="col">Topic Description</th>
                <th scope="col">Add assignment</th>
              </tr>
            </thead>
            <tbody id="course_tbody">
              @php ($slno = 0)
              @foreach($subTopics as $subTopic)
              <!-- @php ($slno = $slno + 1) -->
              <tr id="{{$subTopic->course_id}}">
                <th class="align-middle" scope="row">{{($subTopics->currentpage() -1) * $subTopics->perpage() + $slno }}</th>
                <td class="align-middle">{{$subTopic->topic_title}}</td>
                <td class="align-middle">{{$subTopic->description}}</td>
                <td class="align-middle text-center">
                <a href="" title="Add assignment" class="add-assignment" data-bs-toggle="modal" data-bs-target="#add_assignmnent_modal" data-bs-topic-id="{{$subTopic->topic_id}}">
                <i class="fas fa-plus-square fa-lg"></i>
                  </a>
                </td>
                
              </tr>
              @endforeach
              </tbody>
          </table>
            <div class="d-flex justify-content-end">
            {{ $subTopics->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('add_assignment').addEventListener('click',function(e){
  
var assignmentTitle = document.getElementById('assignment_title');
var assignmentDescription = document.getElementById('assignment_description');



if(assignmentTitle.value === '') {
    e.preventDefault();
    showError(assignmentTitle,'Assignment Title is required');
} else {
    removeError(assignmentTitle)
}
if(assignmentDescription.value === '') {
    e.preventDefault();
    showError(assignmentDescription,'Assignment Description is required');
} else {
    removeError(assignmentDescription)
}

function showError(input,message){
  input.style.borderColor = 'red';
  const formControl=input.parentElement;
  const small=formControl.querySelector('small');
  small.innerText=message;
  small.style.visibility = 'visible';
}

function removeError(input){
    input.style.borderColor = '#ced4da';
  const formControl=input.parentElement;
  const small=formControl.querySelector('small');
  small.style.visibility = 'hidden';
}





});


let assignmentButton = document.getElementsByClassName('add-assignment');

for(var index=0; index<assignmentButton.length; index++){
    assignmentButton[index].addEventListener('click',function(e){

let topicId = this.getAttribute('data-bs-topic-id');
document.getElementById('assignment_topic_id').value = "";
document.getElementById('assignment_topic_id').value = topicId;



});
}

</script>



@endsection('content')