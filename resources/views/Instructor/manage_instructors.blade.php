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
          <h3>Instructors</h3>
          <div class="btn-toolbar mb-2 mb-md-0">
            <a id="add_new_category" class="btn btn-primary add_new_instructor_btn" title="Add new instructor" href="{{ route('add-instructor') }}">
              <i class="fas fa-plus-square me-1"></i>
              Add new Instructor</a>
          </div>
        </div>
        <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col" colspan="2">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Instructor Added On</th>
                <th scope="col" colspan="3" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="instructor_tbody">
              @php ($slno = 0)
              @foreach ($instructors as $instructor)
              @php ($slno = $slno + 1)
              <tr id="{{$instructor->id}}">
                <th class="align-middle" scope="row">{{ ($instructors->currentpage() -1) * $instructors->perpage() + $slno }}</th>
                <td class="align-middle" colspan="2">{{$instructor->firstname}} {{$instructor->lastname}}</td>
                <td class="align-middle">{{$instructor->email}} </td>
                <td class="align-middle"></td>
                <td class="align-middle text-center">
                  <a href="{{ route('view-instructor', ['instructor_id' => $instructor->id]) }}" title="View instructor">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{route('edit-instructor', ['instructor_id' => $instructor->id])}}" title="Edit instructor">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" title="Delete instructor" data-bs-toggle="modal" data-bs-target="#delete_instructor_modal" data-bs-id="{{$instructor->id}}">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
                <!-- <td class="text-center align-middle"><button class="btn btn-primary view_new_instructor_btn" data-bs-toggle="modal" data-bs-target="#view_instructor_modal" data-bs-id="{{$instructor->id}}">View</button></td>
          <td class="text-center align-middle"><button class="btn btn-success edit_new_instructor_btn" data-bs-toggle="modal" data-bs-target="#edit_instructor_modal" data-bs-id="{{$instructor->id}}">Edit</button></td>
          <td class="text-center align-middle"><button class="btn btn-danger delete_new_instructor_btn" data-bs-toggle="modal" data-bs-target="#delete_instructor_modal" data-bs-id="{{$instructor->id}}">Delete</button></td> -->
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-end">
            {!! $instructors->links() !!}
        </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->

<!-- New instructor modal -->
<div id="new_instructor_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Instructor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_add_instructor">
          @csrf
          <div class="mb-3">
            <label for="instructor_first_name" class="col-form-label">First Name</label>
            <input type="text" class="form-control has-validation" id="instructor_first_name"></input>
            <div class="invalid-feedback">Please enter a first name.</div>
          </div>
          <div class="mb-3">
            <label for="instructor_last_name" class="col-form-label">Last Name</label>
            <input type="text" class="form-control has-validation" id="instructor_last_name"></input>
            <div class="invalid-feedback">Please enter a last name.</div>
          </div>
          <div class="mb-3">
            <label for="instructor_email" class="col-form-label">Email</label>
            <input type="email" class="form-control has-validation" id="instructor_email"></input>
            <div class="invalid-feedback">Please enter a valid email id.</div>
          </div>
          <div class="mb-3">
            <label for="instructor_password" class="col-form-label">Password</label>
            <input type="text" class="form-control has-validation" id="instructor_password"></input>
            <div class="invalid-feedback">Please enter a password.</div>
            <button type="button" class="btn btn-link" id="generate_password">Generate password</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="save_instructor" class="btn btn-primary">Add Instructor</button>
      </div>
    </div>
  </div>
</div>
<!-- New course modal ends here -->
<!-- View course modal -->
<div id="view_instructor_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Instructor details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>Instructor Name:</strong></td>
            <td class="text-right"><label id="view_instructor_name"></label></td>
          </tr>
          <tr>
            <td><strong>Email id:</strong></td>
            <td class="text-right"><label id="view_instructor_email"></label></td>
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
<div id="edit_instructor_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit instructor details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_edit_instructor">
          @csrf
          <div class="mb-3">
            <label for="instructor_first_name" class="col-form-label">Instructor's First Name</label>
            <input type="text" class="form-control has-validation" id="edit_instructor_first_name"></input>
            <div class="invalid-feedback">Please enter a first name.</div>
          </div>
          <div class="mb-3">
            <label for="instructor_last_name" class="col-form-label">Instructor's Last Name</label>
            <input type="text" class="form-control has-validation" id="edit_instructor_last_name"></input>
            <div class="invalid-feedback">Please enter a last name.</div>
          </div>
          <div class="mb-3">
            <label for="instructor_email" class="col-form-label">Instructor's Email</label>
            <input type="email" class="form-control has-validation" id="edit_instructor_email"></input>
            <div class="invalid-feedback">Please enter a valid email id.</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="update_instructor_btn" class="btn btn-primary">Update details</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit course modal ends here -->
<!-- Delete course modal -->
<div id="delete_instructor_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete instructor</h5>
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
            <td class="text-center">
              <p>
                <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
                Do you really want to delete this instructor?
              </p>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_instructor_delete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete course modal ends here -->

<script>
  function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!-?';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
  }

  document.getElementById('new_instructor_modal').addEventListener('show.bs.modal', function(event) {
    clearValidationMessage('form_add_instructor');
    document.getElementById('instructor_password').value = makeid(12);
    blurValidation('form_add_instructor');
  });

  document.getElementById('generate_password').addEventListener('click', function(event) {
    document.getElementById('instructor_password').value = makeid(12);
  });

  document.getElementById('save_instructor').addEventListener('click', (event) => {
    const isFormValid = submitValidation('form_add_instructor');
    if (isFormValid === false) {
      return;
    }
    let instructorFirstName = document.getElementById('instructor_first_name').value;
    let instructorLastName = document.getElementById('instructor_last_name').value;
    let instructorEmail = document.getElementById('instructor_email').value;
    let instructorPassword = document.getElementById('instructor_password').value;
   
    let path = "{{ route('add-instructor') }}?instructorFirstName=" + instructorFirstName + "&instructorLastName=" + instructorLastName + "&instructorEmail=" + instructorEmail + "&instructorPassword=" + instructorPassword;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      if (data.status == 'success') {
        document.getElementById('instructor_tbody').innerHTML = '';
        document.getElementById('instructor_tbody').innerHTML = data.html;
        closeModal('new_instructor_modal');
      }
    });
  });

  document.getElementById('view_instructor_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    let path = "{{ route('view-instructor') }}?user_id=" + userId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('view_instructor_name').innerHTML = data.instructorDetails['instructor_name'];
      document.getElementById('view_instructor_email').innerHTML = data.instructorDetails['instructor_email'];
    });
  });

  document.getElementById('edit_instructor_modal').addEventListener('show.bs.modal', function(event) {
    clearValidationMessage('form_edit_instructor');
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    let path = "{{ route('edit-instructor') }}?user_id=" + userId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('edit_instructor_first_name').value = data.instructorDetails['firstname'];
      document.getElementById('edit_instructor_last_name').value = data.instructorDetails['lastname'];
      document.getElementById('edit_instructor_email').value = data.instructorDetails['email'];
      document.getElementById('update_instructor_btn').setAttribute('user_id', data.instructorDetails['id']);
      blurValidation('form_edit_instructor');
      //closeModal('edit_instructor_modal');
    });
  });

  document.getElementById('update_instructor_btn').addEventListener('click', (event) => {
    const isFormValid = submitValidation('form_edit_instructor');
    if (isFormValid === false) {
      return;
    }
    var userId = document.getElementById('update_instructor_btn').getAttribute('user_id');
    var firstname = document.getElementById('edit_instructor_first_name').value;
    var lastname = document.getElementById('edit_instructor_last_name').value;
    var email = document.getElementById('edit_instructor_email').value;
    let path = "{{ route('update-instructor') }}?user_id=" + userId + "&firstname=" + firstname + "&lastname=" + lastname + "&email=" + email;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('instructor_tbody').innerHTML = '';
      document.getElementById('instructor_tbody').innerHTML = data.html;
      closeModal('edit_instructor_modal');
    });
  });

  document.getElementById('delete_instructor_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    confirm_instructor_delete.setAttribute('user_id', userId);
  });

  document.getElementById('confirm_instructor_delete').addEventListener('click', (event) => {
    var userId = document.getElementById('confirm_instructor_delete').getAttribute('user_id');

    let path = "{{ route('delete-instructor') }}?user_id=" + userId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('instructor_tbody').innerHTML = '';
      document.getElementById('instructor_tbody').innerHTML = data.html;
      closeModal('delete_instructor_modal');
    });
  });

  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }

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
