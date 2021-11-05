@extends('Layouts.Profile')
@section('content')
<!-- New course modal -->
<div id="new_course_modal" class="modal fade" tabindex="-1">
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="save_course" class="btn btn-success">Add course</button>
      </div>
    </div>
  </div>
</div>
<!-- New course modal ends here -->
<!-- View course modal -->
<div id="view_course_modal" class="modal fade" tabindex="-1">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- View course modal ends here -->
<!--  Edit course modal -->
<div id="edit_course_modal" class="modal fade" tabindex="-1">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="update_course_btn" class="btn btn-success">Update details</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit course modal ends here -->
<!-- Delete course modal -->
<div id="delete_course_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete course</h5>
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
        <button type="button" id="confirm_course_delete" class="btn btn-danger">Confirm</button>
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
                        <button id="add_new_course" data-bs-toggle="modal" data-bs-target="#new_course_modal" class="btn btn-success add_new_course_btn">Add new course</button>
                    </div>
                   <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Slno.</th>
                        <th scope="col">Course Title</th>
                        <th scope="col">Course Category</th>
                        <th scope="col">Description</th>
                        <th scope="col" colspan="3" class="text-center">Actions</th>
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
                            <td class="text-center align-middle"><button class="btn btn-primary add_new_course_btn" data-bs-toggle="modal" data-bs-target="#view_course_modal" data-bs-id="{{$course['id']}}">View</button></td>
                            <td class="text-center align-middle"><button class="btn btn-success add_new_course_btn" data-bs-toggle="modal" data-bs-target="#edit_course_modal" data-bs-id="{{$course['id']}}">Edit</button></td>
                            <td class="text-center align-middle"><button class="btn btn-danger add_new_course_btn" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="{{$course['id']}}">Delete</button></td>
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
            closeModal('new_course_modal');
        });
    });


    document.getElementById('view_course_modal').addEventListener('show.bs.modal', function (event) {
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

    document.getElementById('edit_course_modal').addEventListener('show.bs.modal', function (event) {
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

    document.getElementById('delete_course_modal').addEventListener('show.bs.modal', function (event) {
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

    function closeModal(modalId) {
      const truck_modal = document.querySelector('#' + modalId);
      const modal = bootstrap.Modal.getInstance(truck_modal);    
      modal.hide();
    }

</script>
@endsection('content')