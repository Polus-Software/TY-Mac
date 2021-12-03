@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-container">
  <div class="row">
    <div class="col-2 position-fixed">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-9 ms-auto">
      <!-- main -->
      <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h3>Courses</h3>
          <div class="btn-toolbar mb-2 mb-md-0">
            <!-- <button id="add_new_course" class="btn btn-primary add_new_course_btn" title="Add New Course"
             data-bs-toggle="modal" data-bs-target="#new_course_modal">
             <i class="fas fa-plus-square me-1"></i>
             Add New Course</button> -->
             <a href="{{ route('add-course') }}" id="add_new_course" class="btn btn-primary add_new_course_btn" title="Add New Course">
             <i class="fas fa-plus-square me-1"></i>
             Add New Course</a>
            <button id="add_sub_topics" class="btn btn-secondary add_new_topics_btn ms-2" title="Add Sub Topics"
             data-bs-toggle="modal" data-bs-target="#new_sub_modal">
             <i class="far fa-plus-square me-1"></i>
             Add Sub Topics</button>
          </div>
        </div>
        <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col">Course Title</th>
                <th scope="col">Course Category</th>
                <th scope="col">Description</th>
                <th scope="col" class="text-center">Actions</th>
                <th scope="col">View Sub-topics</th>
              </tr>
            </thead>
            <tbody id="course_tbody">
              @php ($slno = 0)
              @foreach ($courseDetails as $course)
              @php ($slno = $slno + 1)
              <tr id="{{$course['id']}}">
                <th class="align-middle" scope="row">{{$slno}}</th>
                <td class="align-middle">{{$course['course_title']}}</td>
                <td class="align-middle">{{$course['course_category']}}</td>
                <td class="align-middle">{{$course['description']}}</td>
                <td class="align-middle text-center">
                  <a href="#" title="View course" data-bs-toggle="modal" data-bs-target="#view_course_modal" data-bs-id="{{$course['id']}}">
                  <i class="fas fa-eye"></i>
                  </a>
                  <a href="#" title="Edit course" data-bs-toggle="modal" data-bs-target="#edit_course_modal" data-bs-id="{{$course['id']}}">
                  <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" title="Delete course" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="{{$course['id']}}">
                  <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
                <td class="align-middle text-center">
                <a href="{{ route('view-sub-topic', $course['id']) }}" title="View sub-topics">
                  <i class="fas fa-eye"></i>
                  </a>
                </td>
                <!-- <td class="text-center align-middle"><button class="btn btn-primary add_new_course_btn" data-bs-toggle="modal" data-bs-target="#view_course_modal" data-bs-id="{{$course['id']}}">View</button></td>
          <td class="text-center align-middle"><button class="btn btn-primary add_new_course_btn" data-bs-toggle="modal" data-bs-target="#edit_course_modal" data-bs-id="{{$course['id']}}">Edit</button></td>
          <td class="text-center align-middle"><button class="btn btn-danger add_new_course_btn" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="{{$course['id']}}">Delete</button></td> -->
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->

<!-- New sub modal -->
<div id="new_sub_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add a sub topic</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="POST" action="{{ route('add-sub-topic') }}">
        @csrf
          <div class="mb-3">
            <label for="course" class="col-form-label">Course</label>
            <select class="form-control" id="course" name="course">
              <option value="">Please select a course</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="topic_title" class="col-form-label">Topic Title</label>
            <input type="text" class="form-control" id="topic_title" name="topic_title">
          </div>
          <div class="mb-3">
            <label for="topic_description" class="col-form-label">Topic Description</label>
            <textarea class="form-control" id="topic_description" name="topic_description"></textarea>
          </div>
          <div class="mb-3">
            <label for="course_description" class="col-form-label">Upload study material (if any)</label>
            <input type="file" name="study_material" id="study_material">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="save_sub" class="btn btn-primary">Add sub topic</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- New sub modal ends here -->


<!-- batch sub modal -->
<div id="batch_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add cohort batches</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <div class="mb-3">
            <label for="course" class="col-form-label">Course</label>
            <select class="form-control" id="batch-course" name="course">
              <option value="">Please select a course</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="topic_title" class="col-form-label">Batch name</label>
            <input type="text" class="form-control" id="batch_name" name="topic_title">
          </div>
          <div class="mb-3">
            <label for="batch_start_date" class="col-form-label">Start date</label>
            <input type="date" class="form-control" id="start_date" name="start_date">  
          </div>
          <div class="mb-3">
            <label for="batch_start_date" class="col-form-label">Start time</label>
            <input type="time" class="form-control" id="start_time" name="start_date">  
          </div>
          <div class="mb-3">
            <label for="batch_start_date" class="col-form-label">End time</label>
            <input type="time" class="form-control" id="end_time" name="end_time">  
          </div>
          <div class="mb-3">
            <label for="batch_start_date" class="col-form-label">Duration(in hours)</label>
            <input type="number" class="form-control" id="batch_duration" name="batch_duration">  
          </div>
          <div class="mb-3">
            <label for="batch_region" class="col-form-label">Batch time zone</label>
            <select type="number" class="form-control" id="batch_region" name="batch_region">  
              <option value="IST">IST</option>
              <option value="GMT">GMT</option>
              <option value="PST">PST</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="save_batch" class="btn btn-primary">Add batch</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- New sub modal ends here -->


<!-- New course modal -->
<div id="new_course_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add a new course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ ('add-course') }}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="mb-3">
            <label for="course_category" class="col-form-label">Course Category</label>
            <select class="form-control" id="course_category">
              @foreach ($courseCategories as $courseCategory)
              <option value="{{$courseCategory->id}}">{{$courseCategory->category_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="course_title" class="col-form-label">Course Title</label>
            <input type="text" class="form-control" id="course_title">
          </div>
          <div class="mb-3">
            <label for="course_description" class="col-form-label">Course Description</label>
            <textarea class="form-control" id="course_description"></textarea>
          </div>
          <div class="mb-3">
            <label for="course_instructor" class="col-form-label">Course Instructor</label>
            <select class="form-control" id="course_instructor">
              @foreach ($instructors as $instructor)
              <option value="{{$instructor->id}}">{{$instructor->firstname}} {{$instructor->lastname}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="course_image" class="col-form-label">Upload Course Image</label>
            <input type="file" name="course_image" id="course_image">
            <small id="course_image_error">Error message</small>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" id="save_course" class="btn btn-primary">Add course</button>
      </div>
    </div>
  </div>
</div>
<!-- New course modal ends here -->
<!-- View course modal -->
<div id="view_course_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Course details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>Course Name:</strong></td>
            <td class="text-right"><label id="view_course_name"></label></td>
          </tr>
          <tr>
            <td><strong>Category:</strong></td>
            <td class="text-right"><label id="view_course_category"></label></td>
          </tr>
          <tr>
            <td><strong>Description:</strong></td>
            <td class="text-right"><label id="view_course_description"></label></td>
          </tr>
          <tr>
            <td><strong>Level :</strong></td>
            <td class="text-right"><label id="view_course_difficulty"></label></td>
          </tr>
          <tr>
            <td><strong>Duration :</strong></td>
            <td class="text-right"><label id="view_course_duration"></label></td>
          </tr>
          <tr>
            <td><strong>What you'll learn :</strong></td>
            <td class="text-right"><label id="view_course_short_description"></label>
          </tr>
          <tr>
            <td><strong>Who this course is for :</strong></td>
            <td class="text-right">
              <label id="view_course_details"></label>
            </td>
            <br>
            <td class="text-right">
              <label id="view_course_details_points"></label>
            </td>
          </tr>
         
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- View course modal ends here -->
<!--  Edit course modal -->
<div id="edit_course_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit course details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <div class="mb-3">
            <label for="edit_course_title" class="col-form-label">Course Title</label>
            <input type="text" class="form-control" id="edit_course_title"></input>
          </div>
          <div class="mb-3">
            <label for="edit_course_category" class="col-form-label">Category</label>
            <select type="text" class="form-control" id="edit_course_category">
              @foreach ($courseCategories as $courseCategory)
              <option value="{{$courseCategory->id}}">{{$courseCategory->category_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_course_description" class="col-form-label">Course Description</label>
            <textarea type="email" class="form-control" id="edit_course_description"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_course_instructor" class="col-form-label">Course Instructor</label>
            <select class="form-control" id="edit_course_instructor">
              @foreach ($instructors as $instructor)
              <option value="{{$instructor->id}}">{{$instructor->firstname}} {{$instructor->lastname}}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="update_course_btn" class="btn btn-primary">Update details</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit course modal ends here -->
<!-- Delete course modal -->
<div id="delete_course_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <!-- <tr>
            <td class="text-center"><i class="fas fa-exclamation-triangle" style="font-size:24px;color:red;"></i></td>
          </tr> -->
          <tr>
          </tr>
          <tr>
            <td class="text-center"><p>
            <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
            Do you really want to delete this course?</p></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_course_delete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete course modal ends here -->

<script>

document.getElementById('save_course').addEventListener('click',function(e){

var CourseImage = document.getElementById('course_image');
var filePath = CourseImage.value;


if(filePath == ''){
  e.preventDefault();
  showError(CourseImage,'Please upload  an image');
}else {
  removeError(CourseImage)
  closeModal('new_course_modal')
}

function showError(input,message){
  input.style.borderColor = 'red';
  const small=document.getElementById('course_image_error');
  small.innerText=message;
  small.style.visibility = 'visible';
}

function removeError(input){
input.style.borderColor = '#ced4da';
const small=document.getElementById('course_image_error');
small.style.visibility = 'hidden';
}


function closeModal(modalId) {

  const truck_modal = document.querySelector('#' + modalId);
  const modal = bootstrap.Modal.getInstance(truck_modal);    
  modal.hide();
}  

});


  // document.getElementById('save_course').addEventListener('click', (event) => {
  //   let courseTitle = document.getElementById('course_title').value;
  //   let courseDescription = document.getElementById('course_description').value;
  //   let courseCategory = document.getElementById('course_category').value;
  //   let instructor = document.getElementById('course_instructor').value;
  //   let path = "{{ route('add-course') }}?course_title=" + courseTitle + '&course_description=' + courseDescription + '&course_category=' + courseCategory + '&instructor=' + instructor;
  //   fetch(path, {
  //     method: 'POST',
  //     headers: {
  //       'Accept': 'application/json',
  //       'Content-Type': 'application/json',
  //       "X-CSRF-Token": document.querySelector('input[name=_token]').value
  //     },
  //     body: JSON.stringify({})
  //   }).then((response) => response.json()).then((data) => {
  //     document.getElementById('course_tbody').innerHTML = '';
  //     document.getElementById('course_tbody').innerHTML = data.html;
  //     document.getElementById('course_title').value = '';
  //     document.getElementById('course_description').value = '';
  //     document.getElementById('course_category').value = '';
  //     document.getElementById('course_instructor').value = '';
  //     closeModal('new_course_modal');
  //   });
  // });


  document.getElementById('view_course_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var courseId = button.getAttribute('data-bs-id');
    let path = "{{ route('view-course') }}?course_id=" + courseId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('view_course_name').innerHTML = data.courseDetails['course_name'];
      document.getElementById('view_course_category').innerHTML = data.courseDetails['course_category'];
      document.getElementById('view_course_description').innerHTML = data.courseDetails['course_description'];
      document.getElementById('view_course_difficulty').innerHTML = data.courseDetails['course_difficulty'];
      document.getElementById('view_course_duration').innerHTML = data.courseDetails['course_duration'];
      document.getElementById('view_course_short_description').innerHTML = data.courseDetails['short_description'];
      document.getElementById('view_course_details').innerHTML = data.courseDetails['course_details'];
      document.getElementById('view_course_details_points').innerHTML = data.courseDetails['course_details_points'];

      closeModal('view_course_modal');
    });
  });

  document.getElementById('edit_course_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var courseId = button.getAttribute('data-bs-id');
    let path = "{{ route('edit-course') }}?course_id=" + courseId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      console.log(data.courseDetails['instructor']);
      console.log(data.courseDetails['course_category']);
      document.getElementById('edit_course_title').value = data.courseDetails['course_name'];
      document.getElementById('edit_course_category').value = data.courseDetails['course_category'];
      document.getElementById('edit_course_description').value = data.courseDetails['course_description'];
      document.getElementById('edit_course_instructor').value = data.courseDetails['instructor'];
      document.getElementById('update_course_btn').setAttribute('course_id', data.courseDetails['id']);
    });
  });

  document.getElementById('update_course_btn').addEventListener('click', (event) => {
    var courseId = document.getElementById('update_course_btn').getAttribute('course_id');
    let courseTitle = document.getElementById('edit_course_title').value;
    let courseDescription = document.getElementById('edit_course_description').value;
    let courseCategory = document.getElementById('edit_course_category').value;
    let instructor = document.getElementById('edit_course_instructor').value;
    let path = "{{ route('update-course') }}?course_id=" + courseId + "&course_category=" + courseCategory + "&course_title=" + courseTitle + "&description=" + courseDescription + "&instructor=" + instructor;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('course_tbody').innerHTML = '';
      document.getElementById('course_tbody').innerHTML = data.html;
      closeModal('edit_course_modal');
    });
  });

  document.getElementById('delete_course_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var courseId = button.getAttribute('data-bs-id');
    confirm_course_delete.setAttribute('course_id', courseId);
  });

  document.getElementById('confirm_course_delete').addEventListener('click', (event) => {
    var courseId = document.getElementById('confirm_course_delete').getAttribute('course_id');

    let path = "{{ route('delete-course') }}?course_id=" + courseId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('course_tbody').innerHTML = '';
      document.getElementById('course_tbody').innerHTML = data.html;
      closeModal('delete_course_modal');
    });
  });

  document.getElementById('new_sub_modal').addEventListener('show.bs.modal', function(event) {
    let path = "{{ route('load-courses') }}";
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('course').innerHTML = '';
      document.getElementById('course').innerHTML = data.html;
    });
  });

  document.getElementById('batch_modal').addEventListener('show.bs.modal', function(event) {
    let path = "{{ route('load-courses') }}";
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      console.log(data);
      document.getElementById('batch-course').innerHTML = '';
      document.getElementById('batch-course').innerHTML = data.html;
    });
  });

  document.getElementById('save_batch').addEventListener('click', function(event) {
    let batchCourse = document.getElementById('batch-course').value;
    let batchName = document.getElementById('batch_name').value;
    let startDate = document.getElementById('start_date').value;
    let startTime = document.getElementById('start_time').value;
    let endTime = document.getElementById('end_time').value;
    let batch_duration = document.getElementById('batch_duration').value;
    let timeZone = document.getElementById('batch_region').value;
    let path = "{{ route('save-batch') }}?batchname=" + batchName + "&startDate=" + startDate + "&startTime=" + startTime + "&endTime=" + endTime + "&batch_duration=" + batch_duration + "&batchCourse=" + batchCourse + "&zone=" + timeZone;
    console.log(path);
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      closeModal('batch_modal');
    });
  })

  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }
</script>
@endsection('content')
