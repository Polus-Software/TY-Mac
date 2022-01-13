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
          <h3>Add Sessions</h3>
          
              

          <div class="btn-toolbar mb-2 mb-md-0">
           
          </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 col-6 mb-4">
            <form>
                  <label for="session_title">Session title</label>
                  <input class="form-control" id="session_title"/>
                  <label for="session_course">Course</label>
                  <select class="form-control" id="session_course">
                      <option value="" disabled selected>Please select a course</option>
                      @foreach($courses as $course)
                        <option value="{{$course->id}}">{{$course->course_title}}</option> 
                      @endforeach
                  </select>
                  <label for="session_topic">Topic</label>
                  <select class="form-control" id="session_topic"></select>
                  <label for="session_batch">Batch</label>
                  <select class="form-control" id="session_batch"></select>
                  <label for="session_instructor">Select instructor</label>
                  <select class="form-control" id="session_instructor">
                  <option value="" disabled selected>Please select an instructor</option>
                      @foreach($instructors as $instructor)
                        <option value="{{$instructor->id}}">{{$instructor->firstname}} {{$instructor->lastname}}</option> 
                      @endforeach
                  </select>
                  <button type="button" id="save-session-btn" class="btn btn-secondary mt-3">Add session</button>
            </form>
            </div>
              
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col">Session Title</th>
                <th scope="col">Session Instructor</th>
                <th scope="col">Batch</th>
                <th scope="col">Topic</th>
              </tr>
            </thead>
            <tbody id="course_tbody">
              @if(count($sessions))
              @foreach($sessions as $session)
              <tr>
                <td scope="col">{{ $session['slNo'] }}</td>
                <td scope="col">{{ $session['sessionTitle'] }}</td>
                <td scope="col">{{ $session['instructor'] }}</td>
                <td scope="col">{{ $session['batch'] }}</td>
                <td scope="col">{{ $session['topic'] }}</td>
              </tr>
              @endforeach
              @else
              <tr>
                <td style="text-align:center;" colspan="5">No records</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->


<!-- New course modal -->
<div id="new_course_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add a new course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <div class="mb-3">
            <label for="course_category" class="col-form-label">Course Category</label>
            <select class="form-control" id="course_category">
             
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="save_course" class="btn btn-primary">Add course</button>
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
  document.getElementById('save_course').addEventListener('click', (event) => {
    let courseTitle = document.getElementById('course_title').value;
    let courseDescription = document.getElementById('course_description').value;
    let courseCategory = document.getElementById('course_category').value;
    let instructor = document.getElementById('course_instructor').value;
    let path = "{{ route('add-course') }}?course_title=" + courseTitle + '&course_description=' + courseDescription + '&course_category=' + courseCategory + '&instructor=' + instructor;
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
      document.getElementById('course_title').value = '';
      document.getElementById('course_description').value = '';
      document.getElementById('course_category').value = '';
      document.getElementById('course_instructor').value = '';
      closeModal('new_course_modal');
    });
  });

  document.getElementById('save-session-btn').addEventListener('click', (event) => {
    let sessionTitle = document.getElementById('session_title').value;
    let sessionCourse = document.getElementById('session_course').value;
    let sessionTopic = document.getElementById('session_topic').value;
    let sessionBatch = document.getElementById('session_batch').value;
    let sessionInstructor = document.getElementById('session_instructor').value;
    let path = "{{ route('save-session-details') }}?sessionTitle=" + sessionTitle + '&sessionCourse=' + sessionCourse + '&sessionTopic=' + sessionTopic + '&sessionBatch=' + sessionBatch + '&sessionInstructor=' + sessionInstructor;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      window.location.reload();
    });
  });


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

  document.getElementById('session_course').addEventListener('change', function(event) {
    let courseId = this.value;
    console.log(courseId);
    let path = "{{ route('get-course-attributes') }}?courseId=" + courseId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
        document.getElementById('session_batch').innerHTML = '';
        document.getElementById('session_batch').innerHTML = data.batches;
        document.getElementById('session_topic').innerHTML = '';
        document.getElementById('session_topic').innerHTML = data.topics;
      
    });
  });

  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }
</script>
@endsection('content')
