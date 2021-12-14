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
          <h3>Student details</h3>
        </div>
        <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @php ($slno = 0)
              @foreach($students as $student)
              @php ($slno = $slno + 1)
              <tr id="{{$student->id}}">
                <td>{{ $slno }}</td>
                <td>{{$student->firstname}}</td>
                <td>{{$student->lastname}}</td>
                <td>{{$student->email}}</td>
                <td class="align-middle text-center">
                  <a href="#" title="View student"
                  data-bs-toggle="modal" data-bs-target="#view_student_modal" data-bs-id="{{$student->id}}">
                  <i class="fas fa-eye"></i>
                  </a>
                  <a href="" title="Edit student"
                  data-bs-toggle="modal" data-bs-target="#edit_student_modal" data-bs-id="{{$student->id}}">
                  <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" title="Delete student" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-student="{{ $student->id }}">
                  <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
            {!! $students->links() !!}
          </div>
        </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->
<!-- View student modal -->
<div id="view_student_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Student details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>First Name:</strong></td>
            <td class="text-right"><p class="student_firstname"></p></td>
          </tr>
          <tr>
            <td><strong>Last Name:</strong></td>
            <td class="text-right"><p class="student_lastname"></p></td>
          </tr>
          <tr>
            <td><strong>Email id:</strong></td>
            <td class="text-right"><p class="student_email"></p></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- View student modal ends here -->
<!-- Edit student modal -->
<div id="edit_student_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Student details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form  class="form"  id="editStudentsForm" action="" method="POST">
          @csrf 
          <input type="hidden" name="_method" value="PUT">

          <div class="form-group">
              <label for="firstname" class="pb-1">First Name</label>
              <input type="text" class="form-control edit_firstname has-validation mb-3"  value ="" name="firstname" id="firstname" placeholder="Enter First Name">
              <div class="invalid-feedback">Please enter a first name.</div>
          </div>
          <div class="form-group">
              <label for="lastname" class="pb-1">Last Name</label>
              <input type="text" class="form-control edit_lastname has-validation mb-3" value="" name="lastname" id="lastname" placeholder="Enter Last Name">
              <div class="invalid-feedback">Please enter a lastname.</div>
            </div>
          <div class="form-group">
              <label for="email" class="pb-1">Email</label>
              <input type="email" class="form-control edit_email has-validation mb-3" value="" name="email" id="email" placeholder=" Enter email">
              <div class="invalid-feedback">Please enter a valid email id.</div>
            </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="update_student_btn">Update</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit student modal ends here -->
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
  var deleteModal = document.getElementById('deleteModal');
  deleteModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var recipient = button.getAttribute('data-bs-student')
    var modalBodyButton = deleteModal.querySelector('.modal-footer .delete');
    modalBodyButton.value = recipient;

  });

  document.getElementById('deleteButton').addEventListener('click', function(event) {
    let deleteButton = document.getElementById('deleteButton').value;
    let path = "{{ route('admin.deletestudent')}}?studentId=" + deleteButton;

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
      closeModal('deleteModal');
      window.location.reload();
    });
  });


  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }

  document.getElementById('view_student_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var studentId = button.getAttribute('data-bs-id');
    let path = "{{ route('view-student') }}?student_id=" + studentId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.querySelector('.student_firstname').innerHTML = data.studentDetails['firstname'];
      document.querySelector('.student_lastname').innerHTML = data.studentDetails['lastname'];
      document.querySelector('.student_email').innerHTML = data.studentDetails['email'];
      //closeModal('view_student_modal');
    });
  });

  document.getElementById('edit_student_modal').addEventListener('show.bs.modal', function(event) {
    clearValidationMessage('editStudentsForm');
    var button = event.relatedTarget;
    var studentId = button.getAttribute('data-bs-id');
    let path = "{{ route('view-student') }}?student_id=" + studentId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.querySelector('.edit_firstname').value = data.studentDetails['firstname'];
      document.querySelector('.edit_lastname').value = data.studentDetails['lastname'];
      document.querySelector('.edit_email').value = data.studentDetails['email'];
      document.getElementById('update_student_btn').setAttribute('student_id', data.studentDetails['id']);
      blurValidation('editStudentsForm');
    });
  });

  document.getElementById('update_student_btn').addEventListener('click', (event) => {
    const isFormValid = submitValidation('editStudentsForm');
    if(isFormValid === false){
      return;
    }
    var button = event.relatedTarget;
    var studentId = document.getElementById('update_student_btn').getAttribute('student_id');
    let firstname = document.querySelector('.edit_firstname').value;
    let lastname = document.querySelector('.edit_lastname').value;
    let email = document.querySelector('.edit_email').value;
    let path = "{{ route('update-student') }}?student_id=" + studentId + "&firstname=" + firstname + "&lastname=" + lastname + "&email=" + email;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      closeModal('edit_student_modal');
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
