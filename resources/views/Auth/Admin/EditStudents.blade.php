@extends('Layouts.Profile')
@section('content')
           <div class="container">
             <div class="row"> 
               <div class= "col-lg-6">   
                <form  class="form"  id="editStudentsForm" action="{{ route('admin.updatestudent', $students->id)}}" method="POST">
                        @csrf 
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control"  value ="{{$students->firstname}}" name="firstname" id="firstname" placeholder="Enter First Name">
                            <small>Error message</small>  
                            @if ($errors->has('firstname'))
                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" value="{{$students->lastname}}" name="lastname" id="lastname" placeholder="Enter Last Name">
                            <small>Error message</small>  
                            @if ($errors->has('lastname'))
                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                            @endif
                          </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" value="{{$students->email}}" name="email" id="email" placeholder=" Enter email">
                            <small>Error message</small>  
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                          </div>
                          <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                    </form>
                    </div>   
                    </div>  
                  </div> 

<script src="{{ asset('assets/adminEdit.js') }}"></script>
@endsection('content')


                              