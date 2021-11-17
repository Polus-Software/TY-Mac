@extends('Layouts.Profile')
@section('content')
<!-- New course modal -->
<div id="new_creator_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new Content Creator</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form>
          @csrf
          <div class="mb-3">
            <label for="creator_first_name" class="col-form-label">Content Creator's First Name</label>
            <input type="text" class="form-control" id="creator_first_name"></input>
          </div>
          <div class="mb-3">
            <label for="creator_last_name" class="col-form-label">Content Creator's Last Name</label>
            <input type="text" class="form-control" id="creator_last_name"></input>
          </div>
          <div class="mb-3">
            <label for="creator_email" class="col-form-label">Content Creator's Email</label>
            <input type="text" class="form-control" id="creator_email"></input>
          </div>
          <div class="mb-3">
            <label for="creator_password" class="col-form-label">Content Creator's Password</label>
            <input type="text" class="form-control" id="creator_password"></input><button type="button" class="btn btn-secondary mt-1" id="generate_password">Generate password</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="save_creator" class="btn btn-success">Add Content Creator</button>
      </div>
    </div>
  </div>
</div>
<!-- New course modal ends here -->
<!-- View course modal -->
<div id="view_creator_modal" class="modal fade" tabindex="-1">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- View course modal ends here -->
<!--  Edit course modal -->
<div id="edit_creator_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit creator details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form>
          @csrf
          <div class="mb-3">
            <label for="creator_first_name" class="col-form-label">Content Creator's First Name</label>
            <input type="text" class="form-control" id="edit_creator_first_name"></input>
          </div>
          <div class="mb-3">
            <label for="creator_last_name" class="col-form-label">Content Creator's Last Name</label>
            <input type="text" class="form-control" id="edit_creator_last_name"></input>
          </div>
          <div class="mb-3">
            <label for="creator_email" class="col-form-label">Content Creator's Email</label>
            <input type="email" class="form-control" id="edit_creator_email"></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="update_creator_btn" class="btn btn-success">Update details</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit course modal ends here -->
<!-- Delete course modal -->
<div id="delete_creator_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete course category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <table class="table table-borderless">
            <tr>
              <td class="text-center"><i class="fas fa-exclamation-triangle" style="font-size:24px;color:red;"></i></td>
            </tr>
            <tr>
            </tr>
            <tr>
              <td class="text-center"><strong>Are you sure?</strong></td>
            </tr>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="confirm_creator_delete" class="btn btn-danger">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete course modal ends here -->
<div class="container">
       <div class="custom-container mx-auto border">
           <div class="row">                    
               <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 m-auto">
                   <div class="content-page">
                    <div class="mb-3">
                        <button id="add_new_category" data-bs-toggle="modal" data-bs-target="#new_creator_modal" class="btn btn-success add_new_creator_btn">Add new Content Creator</button>
                    </div>
                   <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
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
                            <th class="align-middle" scope="row">{{$slno}}</th>
                            <td class="align-middle" colspan="2">{{$creator->firstname}} {{$creator->lastname}}</td>
                            <td class="align-middle">{{$creator->email}} </td>
                            <td class="align-middle">Dummy</td>
                            <td class="text-center align-middle"><button class="btn btn-primary view_new_creator_btn" data-bs-toggle="modal" data-bs-target="#view_creator_modal" data-bs-id="{{$creator->id}}">View</button></td>
                            <td class="text-center align-middle"><button class="btn btn-success edit_new_creator_btn" data-bs-toggle="modal" data-bs-target="#edit_creator_modal" data-bs-id="{{$creator->id}}">Edit</button></td>
                            <td class="text-center align-middle"><button class="btn btn-danger delete_new_creator_btn" data-bs-toggle="modal" data-bs-target="#delete_creator_modal" data-bs-id="{{$creator->id}}">Delete</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                     </div>
               </div>
           </div>

       </div>
</div>

<script>

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!-?';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    document.getElementById('new_creator_modal').addEventListener('show.bs.modal', function (event) {
        document.getElementById('creator_password').value = makeid(12);
    });

    document.getElementById('generate_password').addEventListener('click', function(event) {
        document.getElementById('creator_password').value = makeid(12);
    });

    document.getElementById('save_creator').addEventListener('click', (event) => {
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

    document.getElementById('view_creator_modal').addEventListener('show.bs.modal', function (event) {
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

    document.getElementById('edit_creator_modal').addEventListener('show.bs.modal', function (event) {
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
        });
    });

    document.getElementById('update_creator_btn').addEventListener('click', (event) => {
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

    document.getElementById('delete_creator_modal').addEventListener('show.bs.modal', function (event) {
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
        });
    });

    function closeModal(modalId) {
      const truck_modal = document.querySelector('#' + modalId);
      const modal = bootstrap.Modal.getInstance(truck_modal);    
      modal.hide();
    }

</script>