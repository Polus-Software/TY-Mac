@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container-fluid llp-container">
  <div class="row">
    <div class="left_sidebar">
      <!-- include sidebar here -->
      @include('Layouts.admin.sidebar')
    </div>
    <div class="col-8 right_card_block">
      <!-- main -->
      <main>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
          <h3 class="titles">Attendance Tracking Data</h3>
        </div>
        <div class="row mt-4">
        <form action="{{ route('get.attendance.data') }}" method="GET" class="row g-3 llp-form">
            @csrf
            <div class="col-6">
                <label for="course">Course</label>
                <select class="form-control mt-2" id="course" name="course">
                    <option value>Select a course</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label for="batch">Batch</label>
                <select class="form-control mt-2" id="batch" name="batch">
                    <option value>Select a Batch</option>
                </select>
            </div>
            <div class="col-6">
                <label for="live_session">Live session</label>
                <select class="form-control mt-2" id="live_session" name="live_session">
                    <option value>Select a Session</option>
                </select>
            </div>
            <div class="col-3 mt-5">
                
            </div>
            <div class="col-3 mt-5" style="text-align:right;">
                <button id="get_table" type="button" class="btn btn-outline-secondary">Get data</button>
            </div>
        </form>
        </div>
        <div class="row mt-4">
          <table class="table llp-table table-responsive mt-4">
            <thead>
              <tr>
                <th scope="col" class="align-middle text-center">#</th>
                <th scope="col" class="align-middle text-center"></th>
                <th scope="col" class="align-middle">First Name</th>
                <th scope="col" class="align-middle">Last Name</th>
                <th scope="col" class="align-middle text-center">Time spent</th>
                <th scope="col" class="align-middle text-center">Percent attended</th>
                <th scope="col" class="align-middle text-center">Status</th>
              </tr>
            </thead>
            <tbody id="tracker_body">
              <tr>
                  <td colspan="7" class="align-middle text-center"><h6>Search for a live session above.</h6></td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
              
          </div>
        </div>
      </main>
      <!-- main ends -->

    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- container ends -->

<!-- Delete Modal -->
<div class="modal fade llp-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModallLabel">Are you sure?</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <p>
            <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
            Do you really want to delete this student? </p>
          </div>
          <input type="hidden" name="studentId" id="studentId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger delete" id="deleteButton">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

document.getElementById('get_table').addEventListener('click', function(event) {
    let sessionId = document.getElementById('live_session').value;

    let path = "{{ route('get.attendance.table')}}?sessionId=" + sessionId;

    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
        if(data.status == "success") {
            document.getElementById('tracker_body').innerHTML = data.html;
        }
        
    });
});

document.getElementById('course').addEventListener('change', function(event) {
    let courseId = this.value;
    let path = "{{ route('get.attendance.batches')}}?courseId=" + courseId;

    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
        if(data.status == "success") {
            let html = '<option value>Select a batch</option>';
            for(i=0;i<data.batches.length;i++) {
                html = html + '<option value="' + data.batches[i].id + '">' + data.batches[i].batchname + '</option>';
            }
            document.getElementById('batch').innerHTML = html;
        }
        
    });
});


document.getElementById('batch').addEventListener('change', function(event) {
    let batchId = this.value;
    let path = "{{ route('get.attendance.sessions')}}?batchId=" + batchId;

    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
        if(data.status == "success") {
            let html = '<option value>Select a batch</option>';
            for(i=0;i<data.sessions.length;i++) {
                html = html + '<option value="' + data.sessions[i].live_session_id + '">' + data.sessions[i].session_title + '</option>';
            }
            document.getElementById('live_session').innerHTML = html;
        }
        
    });
});
 
  
  clearValidationMessage = (formId) => {
    document.querySelectorAll(`#${formId} input.has-validation`).forEach(field => {
      if (field.parentElement.querySelector('.invalid-feedback').classList.contains('d-block')) {
        field.parentElement.querySelector('.invalid-feedback').classList.remove('d-block');
      }
    })
  }
  blurValidation = (formId) => {
    document.querySelectorAll(`#${formId} input.has-validation`).forEach(field => {
      field.addEventListener('blur', (event) => {
        validateField(event.target);
      });
    });
  }
  submitValidation = (formId) => {
    const fields = document.querySelectorAll(`#${formId} input.has-validation`);
    for (field of fields) {
      let result = validateField(field);
      if (result === false) return result;
    }
    return true;
  }
  validateField = (field) => {
    if (field.value.trim() === "") {
      field.parentElement.querySelector('.invalid-feedback').classList.add('d-block');
      return false;
    }
    if (field.type === 'email') {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (!field.value.match(mailformat)) {
        field.parentElement.querySelector('.invalid-feedback').classList.add('d-block');
        return false;
      }
    }
    field.parentElement.querySelector('.invalid-feedback').classList.remove('d-block');
    return true;
  }

</script>

@endsection('content')
