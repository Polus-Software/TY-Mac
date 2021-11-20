@extends('Layouts.admin.master')
@section('content')
@include('Layouts.admin.header')
<!-- container -->
<div class="container llp-content-mt">
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
              @foreach($students as $student)
              <tr>
                <td>{{$student->id}}</td>
                <td>{{$student->firstname}}</td>
                <td>{{$student->lastname}}</td>
                <td>{{$student->email}}</td>
                <td class="text-center">
                  <a href="{{ route('admin.showstudent', $student->id) }}" title="View student">
                    <svg class="bi me-2" width="16" height="16">
                      <use xlink:href="#eye-fill" />
                    </svg>
                  </a>
                  <a href="{{ route('admin.editstudent', $student->id) }}" title="Edit student">
                    <svg class="bi me-2" width="16" height="16">
                      <use xlink:href="#pencil-fill" />
                    </svg>
                  </a>
                  <a href="#" title="Delete student" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-student="{{ $student->id }}">
                    <svg class="bi me-2" width="16" height="16">
                      <use xlink:href="#trash-fill" />
                    </svg>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
            <p>Do you really want to delete these records? </p>
          </div>
          <input type="hidden" name="studentId" id="studentId">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
</script>

@endsection('content')
