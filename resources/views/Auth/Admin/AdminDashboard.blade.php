@extends('Layouts.app')
@section('content')

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


<div class="container">
    <h1 class="text-center">student details</h1>
   
    <table class="table table-dark table-hover">
        <thead>
            <tr class="table-dark">
                <td>ID</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td class="text-center">Actions</td>
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
                
                            <a href="{{ route('admin.editstudent', $student->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <a href="{{ route('admin.showstudent', $student->id) }}" class="btn btn-primary btn-sm">View</a>
                        
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-student="{{ $student->id }}">Delete</button>

               
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
 
</div>
<div class="d-flex justify-content-center">
     {!! $students->links() !!}      
</div>

<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var recipient = button.getAttribute('data-bs-student')
    var modalBodyButton = deleteModal.querySelector('.modal-footer .delete');
    modalBodyButton.value = recipient;

    console.log(modalBodyButton.value);

});
    
    document.getElementById('deleteButton').addEventListener('click', function (event) {
    let deleteButton = document.getElementById('deleteButton').value;

    console.log(deleteButton);
    let path = "{{ route('admin.deletestudent')}}?studentId=" + deleteButton;
    
    console.log(path);
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
        });
    });
</script>

@endsection

