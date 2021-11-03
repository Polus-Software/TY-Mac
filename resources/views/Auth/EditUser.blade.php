@extends('Layouts.Profile')

@section('content')

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="uploadModallLabel">Change Profile Photo</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" action="{{ route('change.avatar.post') }}">
        @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="file-upload"></label>
                    <input type="file" name="image" id="image"> 
                    @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif                               
                 </div>
            </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" value="" id="uploadButton">Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
       
       <div class="custom-container mx-auto border">
           <div class="row">                    
               <div class="col-lg-4 col-sm-4 col-md-4 col-xs-3">
                   <div class="sidebar col-md-4 col-sm-2">
                       <div class="side-heading border-bottom">
                           <span><p class="heading-1">My Account</p></span>
                       </div>
                       <div class="text-left">
                          <nav class="nav flex-column" id="navmenu">
                           <a class="nav-link link-1 active" aria-current="page" href="#">My Profile<span><i class="fas fa-arrow-right active"></i></span></a>
                           <a class="nav-link link-2" href="{{ route('change.password.get') }}">Change Password<span><i class="fas fa-arrow-right"></i></span></a>
                           <a class="nav-link link-3" href="#">Email Notifications<span><i class="fas fa-arrow-right"></i></span></a>
                           <a class="nav-link link-4" href="#">My Favorite Courses<span><i class="fas fa-arrow-right"></i></span></a>
                           <a class="nav-link link-5" href="#">My Courses<span><i class="fas fa-arrow-right"></i></span></a>
                         </nav>
                         
                       </div>
                   </div>
               </div>
               <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9">
                   <div class="content-page">
                        <div class="content-top">
                           <div class="card col-sm-8 mx-auto">

                               <img class="card-img-top rounded-circle mx-auto" src="{{asset('/storage/images/'.Auth::user()->image)}}" alt="profilepicture">
                               <div class="card-body text-center">
                                    <span class="card-text-1">
                                        <a href="#" class="card-title" data-bs-toggle="modal" data-bs-target="#uploadModal">Change Photo</a>
                                    </span>

                                   <p class="card-text-2">{{Auth::user()->firstname.' '. Auth::user()->lastname}}</p>
                                   <p class="card-text-3">{{Auth::user()->email}}</p>
                               </div>
                            </div>
                            <div class="border-bottom"></div>
                        </div>
                        <form class="form"id="editUserForm" method="POST" action="{{ route('profileUpdate') }}">
                           @csrf
                           <input type="hidden" name="_method" value="PUT">
                           <div class="row">
                             <div class="form-group col-md-6 col-sm-6 col-xs-2">
                               <label for="fname" class="firstname-label">First Name</label>
                               <input type="text" class="form-control" name="firstname" id="firstname" value="{{Auth::user()->firstname}}">
                               <small>Error message</small>
                                   
                            @if ($errors->has('firstname'))
                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                            @endif
                             </div>
                             <div class="form-group col-md-6 col-sm-6 col-xs-2">
                               <label for="lname" class="lastname-label">Last Name</label>
                               <input type="text" class="form-control" name="lastname" id="lastname" value="{{Auth::user()->lastname}}">
                               <small>Error message</small>
                               
                            @if ($errors->has('lastname'))
                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                            @endif
                             </div>
                           </div>
                           <div class="row">
                             <div class="form-group col-md-12 col-sm-12 col-xs-2">
                               <label for="email" class="email-label">Email</label>
                               <input type="email" class="form-control"  name="email" id="email" value="{{ Auth::user()->email }}">
                               <small>Error message</small>

                               @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                             </div>
                           </div>
                           <div class="row">
                               <div class="form-group buttons d-flex justify-content-end">
                                   <button type="submit" class="btn back-btn">
                                   <a href="{{route('dashboard')}}">Back</a></button>
                                   <button type="submit" class="btn update-btn">Update</button>
                               </div>
                           </div>
                        </form>      
                    </div>
                </div>
            </div>
        </div>
</div>
<script src="{{ asset('assets/editUser.js') }}"></script>


@endsection('content')