@extends('Layouts.app')
<h1 class="text-center">student details</h1>

<!-- <ul>
    @foreach($students as $student)
    <li>{{$student->firstname}}</li>
    <li>{{$student->email}}</li>
    
@endforeach
</ul> -->
<div class="container">
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
                <a href="{{route('admin.edit',$student->id)}}" class="btn btn-success btn-sm">Edit</a>
                <a href="#" class="btn btn-primary btn-sm">View</a>
                <form action="#" method="post" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                  </form>
            </td>
        </tr>
        @endforeach
   </tbody>
  </table>
 
</div>