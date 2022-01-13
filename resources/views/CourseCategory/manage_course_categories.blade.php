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
          <h3>Course categories</h3>
          <div class="btn-toolbar mb-2 mb-md-0">
            <button id="add_new_category" class="btn btn-primary add_new_category_btn" title="Add new category"
             data-bs-toggle="modal" data-bs-target="#new_category_modal">
             <i class="fas fa-plus-square me-1"></i>
             Add new category</button>
          </div>
        </div>
        <div class="row mt-4">
          <table class="table llp-table">
            <thead>
              <tr>
                <th scope="col">Slno.</th>
                <th scope="col" colspan="2">Course Category</th>
                <th scope="col" colspan="3" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="courses_category_tbody">
              @php ($slno = 0)
              @foreach ($courseCategories as $courseCategory)
              @php ($slno = $slno + 1)
              <tr id="{{$courseCategory['id']}}">
                <th class="align-middle" scope="row">{{ ($courseCategories->currentpage() -1) * $courseCategories->perpage() + $slno  }}</th>
                <td class="align-middle" colspan="2">{{$courseCategory['category_name']}}</td>
                <td class="align-middle text-center">
                  <a href="#" title="View course category" data-bs-toggle="modal" data-bs-target="#view_category_modal" data-bs-id="{{$courseCategory['id']}}">
                  <i class="fas fa-eye"></i>
                  </a>
                  <a href="#" title="Edit course category" data-bs-toggle="modal" data-bs-target="#edit_category_modal" data-bs-id="{{$courseCategory['id']}}">
                  <i class="fas fa-pen"></i>
                  </a>
                  <a href="#" title="Delete course category" data-bs-toggle="modal" data-bs-target="#delete_category_modal" data-bs-id="{{$courseCategory['id']}}">
                  <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
                <!-- <td class="text-center align-middle"><button class="btn btn-primary view_new_course_btn" data-bs-toggle="modal" data-bs-target="#view_category_modal" data-bs-id="{{$courseCategory['id']}}">View</button></td>
          <td class="text-center align-middle"><button class="btn btn-success edit_new_course_btn" data-bs-toggle="modal" data-bs-target="#edit_category_modal" data-bs-id="{{$courseCategory['id']}}">Edit</button></td>
          <td class="text-center align-middle"><button class="btn btn-danger delete_new_course_btn" data-bs-toggle="modal" data-bs-target="#delete_category_modal" data-bs-id="{{$courseCategory['id']}}">Delete</button></td> -->
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-end">
            {!! $courseCategories->links() !!}
          </div>
      </main>
      <!-- main ends -->

    </div>
  </div>
</div>
<!-- container ends -->

<!-- New course modal -->
<div id="new_category_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new course category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <div class="mb-3">
            <label for="course_category" class="col-form-label">Course Category Name</label>
            <input type="text" class="form-control" id="course_category"></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="save_category" class="btn btn-primary">Add category</button>
      </div>
    </div>
  </div>
</div>
<!-- New course modal ends here -->
<!-- View course modal -->
<div id="view_category_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View course category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tr>
            <td><strong>Course Category Name:</strong></td>
            <td class="text-right"><label id="view_category_name"></label></td>
          </tr>
          <tr>
            <td><strong>Course added on:</strong></td>
            <td class="text-right"><label id="view_category_added_date"></label></td>
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
<div id="edit_category_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit course category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          @csrf
          <div class="mb-3">
            <label for="course_category" class="col-form-label">Course Category Name</label>
            <input type="text" class="form-control" id="edit_category_name"></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="update_category_btn" class="btn btn-primary">Update category</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit course modal ends here -->
<!-- Delete course modal -->
<div id="delete_category_modal" class="modal fade llp-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete course category</h5>
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
            Do you really want to delete this category?</p></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirm_category_delete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete course modal ends here -->

<script>
  document.getElementById('save_category').addEventListener('click', (event) => {
    let categoryName = document.getElementById('course_category').value;
    let path = "{{ route('add-course-category') }}?category_name=" + categoryName;
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
        document.getElementById('courses_category_tbody').innerHTML = '';
        document.getElementById('courses_category_tbody').innerHTML = data.html;
        closeModal('new_category_modal');
        window.location.reload();
      }
    });
  });

  document.getElementById('view_category_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var categoryId = button.getAttribute('data-bs-id');
    let path = "{{ route('view-course-category') }}?category_id=" + categoryId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('view_category_name').innerHTML = data.categoryDetails['category_name'];
      document.getElementById('view_category_added_date').innerHTML = data.categoryDetails['category_added_on'];
    });
  });

  document.getElementById('edit_category_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var categoryId = button.getAttribute('data-bs-id');
    let path = "{{ route('edit-course-category') }}?category_id=" + categoryId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('edit_category_name').value = data.categoryDetails['category_name'];
      document.getElementById('update_category_btn').setAttribute('category_id', data.categoryDetails['category_id']);
    });
  });

  document.getElementById('update_category_btn').addEventListener('click', (event) => {
    var categoryId = document.getElementById('update_category_btn').getAttribute('category_id');
    var newCategoryName = document.getElementById('edit_category_name').value;

    let path = "{{ route('update-course-category') }}?category_id=" + categoryId + "&new_category_name=" + newCategoryName;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      document.getElementById('courses_category_tbody').innerHTML = '';
      document.getElementById('courses_category_tbody').innerHTML = data.html;
      closeModal('edit_category_modal');
    });
  });

  document.getElementById('delete_category_modal').addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var categoryId = button.getAttribute('data-bs-id');
    confirm_category_delete.setAttribute('category_id', categoryId);
  });

  document.getElementById('confirm_category_delete').addEventListener('click', (event) => {
    var categoryId = document.getElementById('confirm_category_delete').getAttribute('category_id');

    let path = "{{ route('delete-course-category') }}?category_id=" + categoryId;
    fetch(path, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
      body: JSON.stringify({})
    }).then((response) => response.json()).then((data) => {
      console.log(categoryId);
      document.getElementById('courses_category_tbody').innerHTML = '';
      document.getElementById('courses_category_tbody').innerHTML = data.html;
      closeModal('delete_category_modal');
    });
  });

  function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    modal.hide();
  }
</script>
@endsection('content')
