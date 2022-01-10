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
          <h3>Content creators</h3>
          <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-primary" href="{{ route('add-creator') }}" title="add creator">
            <i class="fas fa-plus-square me-1"></i>
            Add new Content Creator
                  </a>
          </div>
        </div>
        <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col" colspan="2">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Content Creator Added On</th>
                <th scope="col" colspan="3" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="creator_tbody">
              @php ($slno = 0)
              @foreach ($creators as $creator)
              @php ($slno = $slno + 1)
              <tr id="{{$creator->id}}">
                <th class="align-middle" scope="row">{{  ($creators->currentpage() -1) * $creators->perpage() + $slno }}</th>
                <td class="align-middle" colspan="2">{{$creator->firstname}} {{$creator->lastname}}</td>
                <td class="align-middle">{{$creator->email}} </td>
                <td class="align-middle">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $creator->created_at)->format('F d, Y')}}</td>
                <td class="align-middle text-center">
                  <a href="{{ route('view-creator', ['creator_id' => $creator->id]) }}" title="View creator">
                  <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('edit-creator', ['creator_id' => $creator->id]) }}" title="Edit creator">
                  <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" title="Delete creator" data-bs-toggle="modal" data-bs-target="#delete_creator_modal" data-bs-id="{{$creator->id}}">
                  <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-end">
            {!! $creators->links() !!}
          </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->

<!-- New course modal -->
<div id="new_creator_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new Content Creator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_new_creator">
          @csrf
          <div class="mb-3">
            <label for="creator_first_name" class="col-form-label">Content Creator's First Name</label>
            <input type="text" class="form-control has-validation" id="creator_first_name"></input>
            <div class="invalid-feedback">Please enter a first name.</div>
          </div>
          <div class="mb-3">
            <label for="creator_last_name" class="col-form-label">Content Creator's Last Name</label>
            <input type="text" class="form-control has-validation" id="creator_last_name"></input>
            <div class="invalid-feedback">Please enter a last name.</div>
          </div>
          <div class="mb-3">
            <label for="creator_email" class="col-form-label">Content Creator's Email</label>
            <input type="email" class="form-control has-validation" id="creator_email"></input>
            <div class="invalid-feedback">Please enter a valid email.</div>
          </div>
          <div class="mb-3">
            <label for="creator_password" class="col-form-label">Content Creator's Password</label>
            <input type="text" class="form-control has-validation" id="creator_password"></input>
            <div class="invalid-feedback">Please enter a password.</div>
            <button type="button" class="btn btn-link" id="generate_password">Generate password</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="save_creator" class="btn btn-primary">Add Content Creator</button>
      </div>
    </div>
  </div>
</div>
<!-- New course modal ends here -->
<!-- View course modal -->
<div id="view_creator_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Content Creator details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>Content Creator Name:</strong></td>
            <td class="text-right"><label id="view_creator_name"></label></td>
          </tr>
          <tr>
            <td><strong>Email id:</strong></td>
            <td class="text-right"><label id="view_creator_email"></label></td>
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
<div id="edit_creator_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit creator details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_edit_creator">
          @csrf
          <div class="mb-3">
            <label for="creator_first_name" class="col-form-label">Content Creator's First Name</label>
            <input type="text" class="form-control has-validation" id="edit_creator_first_name"></input>
            <div class="invalid-feedback">Please enter a first name.</div>
          </div>
          <div class="mb-3">
            <label for="creator_last_name" class="col-form-label">Content Creator's Last Name</label>
            <input type="text" class="form-control has-validation" id="edit_creator_last_name"></input>
            <div class="invalid-feedback">Please enter a last name.</div>
          </div>
          <div class="mb-3">
            <label for="creator_email" class="col-form-label">Content Creator's Email</label>
            <input type="email" class="form-control has-validation" id="edit_creator_email"></input>
            <div class="invalid-feedback">Please enter a valid email id.</div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="update_creator_btn" class="btn btn-primary">Update details</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit course modal ends here -->
<!-- Delete course modal -->
<div id="delete_creator_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete content creator</h5>
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
            Do you really want to delete this content creator?</p></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_creator_delete" class="btn btn-danger">Delete</button>
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

  document.getElementById('new_creator_modal').addEventListener('show.bs.modal', function(event) {
    clearValidationMessage('form_new_creator');
    document.getElementById('creator_password').value = makeid(12);
    blurValidation('form_new_creator');
  });

  document.getElementById('generate_password').addEventListener('click', function(event) {
    document.getElementById('creator_password').value = makeid(12);
  });

  document.getElementById('save_creator').addEventListener('click', (event) => {
    const isFormValid = submitValidation('form_new_creator');
    if (isFormValid === false) {
      return;
    }
    let creatorFirstName = document.getElementById('creator_first_name').value;
    let creatorLastName = document.getElementById('creator_last_name').value;
    let creatorEmail = document.getElementById('creator_email').value;
    let creatorPassword = document.getElementById('creator_password').value;
    let path = "{{ route('add-creator') }}?creatorFirstName=" + creatorFirstName + "&creatorLastName=" + creatorLastName + "&creatorEmail=" + creatorEmail + "&creatorPassword=" + creatorPassword;
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
        document.getElementById('creator_tbody').innerHTML = '';
        document.getElementById('creator_tbody').innerHTML = data.html;
        closeModal('new_creator_modal');
      }
    });
  });

  document.getElementById('view_creator_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    let path = "{{ route('view-creator') }}?user_id=" + userId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('view_creator_name').innerHTML = data.creatorDetails['creator_name'];
      document.getElementById('view_creator_email').innerHTML = data.creatorDetails['creator_email'];
    });
  });

  document.getElementById('edit_creator_modal').addEventListener('show.bs.modal', function(event) {
    clearValidationMessage('form_edit_creator');
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    let path = "{{ route('edit-creator') }}?user_id=" + userId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('edit_creator_first_name').value = data.creatorDetails['firstname'];
      document.getElementById('edit_creator_last_name').value = data.creatorDetails['lastname'];
      document.getElementById('edit_creator_email').value = data.creatorDetails['email'];
      document.getElementById('update_creator_btn').setAttribute('user_id', data.creatorDetails['id']);
      blurValidation('form_edit_creator');
    });
  });

  document.getElementById('update_creator_btn').addEventListener('click', (event) => {
    const isFormValid = submitValidation('form_edit_creator');
    if (isFormValid === false) {
      return;
    }
    var userId = document.getElementById('update_creator_btn').getAttribute('user_id');
    var firstname = document.getElementById('edit_creator_first_name').value;
    var lastname = document.getElementById('edit_creator_last_name').value;
    var email = document.getElementById('edit_creator_email').value;
    let path = "{{ route('update-creator') }}?user_id=" + userId + "&firstname=" + firstname + "&lastname=" + lastname + "&email=" + email;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('creator_tbody').innerHTML = '';
      document.getElementById('creator_tbody').innerHTML = data.html;
      closeModal('edit_creator_modal');
    });
  });

  document.getElementById('delete_creator_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    confirm_creator_delete.setAttribute('user_id', userId);
  });

  document.getElementById('confirm_creator_delete').addEventListener('click', (event) => {
    var userId = document.getElementById('confirm_creator_delete').getAttribute('user_id');

    let path = "{{ route('delete-creator') }}?user_id=" + userId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('creator_tbody').innerHTML = '';
      document.getElementById('creator_tbody').innerHTML = data.html;
      closeModal('delete_creator_modal');
      // window.location.reload();
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
