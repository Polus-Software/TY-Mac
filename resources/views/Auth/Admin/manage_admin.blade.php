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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 titles_outer">
          <h3 class="titles">Admin Users</h3>
          <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-primary" href="{{ route('add-admin') }}" title="add admin">
            <i class="fas fa-plus-square me-1"></i>
            Add new Admin
                  </a>
          </div>
        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col" colspan="2">Name</th>
                <th scope="col">E-mail ID</th>
                <th scope="col">Admin Added On</th>
                <th scope="col" colspan="3" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="admin_tbody">
              @php ($slno = 0)
              @if(!empty($admins))
              @foreach ($admins as $admin)
              @php ($slno = $slno + 1)
              <tr id="{{$admin->id}}">
                <th class="align-middle" scope="row">{{  ($admins->currentpage() -1) * $admins->perpage() + $slno }}</th>
                <td class="align-middle" colspan="2">{{$admin->firstname}} {{$admin->lastname}}</td>
                <td class="align-middle">{{$admin->email}} </td>
                <td class="align-middle">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $admin->created_at)->format('m/d/Y')}}</td>
                <td class="align-middle text-center">
                  <a href="{{ route('view-admin', ['admin_id' => $admin->id]) }}" title="View Admin">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('edit-admin', ['admin_id' => $admin->id]) }}" title="Edit admin">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" title="Delete admin" data-bs-toggle="modal" data-bs-target="#delete_admin_modal" data-bs-id="{{$admin->id}}">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              @endforeach
              @else
                 <tr>
                     <td colspan="8"><h6 style="text-align:center;">No admins added.</h6></td>
                 </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-end">
            {!! $admins->links() !!}
          </div>
      </main>
      <!-- main ends -->

    </div>
	<div class="col-1"></div>
  </div>
</div>
<!-- Delete admin Modal-->
<div id="delete_admin_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td class="text-center"><p>
            <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
            Do you really want to delete this Admin?</p></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
          @csrf
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_admin_delete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete modal ends -->

<script>
document.getElementById('delete_admin_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-bs-id');
    confirm_admin_delete.setAttribute('user_id', userId);
  });

  document.getElementById('confirm_admin_delete').addEventListener('click', (event) => {
    var userId = document.getElementById('confirm_admin_delete').getAttribute('user_id');

    let path = "{{ route('delete-admin') }}?user_id=" + userId;
   
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('admin_tbody').innerHTML = '';
      document.getElementById('admin_tbody').innerHTML = data.html;
      closeModal('delete_admin_modal');
    //   window.location.reload();
    });
  });

  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }
</script>
<!-- container ends -->