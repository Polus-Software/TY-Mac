@extends('Layouts.Profile')

@section('content')
@extends('header')
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="uploadModallLabel">Change Profile Photo</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form enctype="multipart/form-data" method="POST" action="{{ route('change.avatar.post') }}">
        @csrf
            <div class="modal-body mt-4">
                <div class="mb-3">
                    <label for="file-upload"></label>
                    <input type="file" name="image" id="image" class="form-control"> 
                    <small id="profile_picture_error">Error message</small>
                    @if ($errors->has('image'))
                      <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif                               
                </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="uploadButton">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="custom-container mx-auto mb-5">
    <div class="row ms-0 me-0 p-4">                    
        <div class="col-lg-3 col-sm-4 col-md-4 col-sm-12 col-12 ps-0">
           <div class="h-100 bg-light think-bg-sidebar rounded-3">
                <div class="side-heading p-4">
                  <p class="heading-1 mb-0">My Account</p>
                </div>
            
                <ul class="nav nav-pills flex-column mb-auto mt-3">
                
                  <li class="nav-item">
                    <a class="nav-link link-dark py-3 ps-4 active" href="#">
                    <i class="fas fa-user pe-2"></i>
                      My Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link link-dark py-3 ps-4" href="{{ route('change.password.get') }}">
                    <i class="fas fa-lock pe-2"></i>
                      Change Password</a>
                  </li>
                </ul>
              </div>
          </div>
          <div class="col-lg-9 col-md-8 col-sm-12 col-12">
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
                      <div class="form-group col-md-12 col-sm-12 col-xs-2">
                        <label for="email" class="email-label">Timezone</label>
                        <select type="select" class="form-control" name="timezone" id="timezone" value="{{ Auth::user()->timezone }}">
                        <option value="">Select Timezone</option>
                        <!-- include timezones here -->
                        @include('Course.admin.timezones')
                        </select>
                        <small>Error message</small>

                        @if ($errors->has('timezone'))
                        <span class="text-danger">{{ $errors->first('timezone') }}</span>
                    @endif
                      </div>
                    </div>
                    <div class="row">
                        <div class="form-group buttons d-flex justify-content-end">
                          @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                            <a href="/" class="btn think-btn-secondary-outline">Cancel</a>
                          @else
                            <a href="/dashboard" class="btn think-btn-secondary-outline">Cancel</a>
                          @endif
                            <button type="submit" class="btn btn-secondary think-btn-secondary ms-3">Update</button>
                        </div>
                    </div>
                </form>      
              </div>
          </div>
      </div>
  </div>
</div>

<footer>
        <div class="ty-mac-footer">
            <div class="container">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-6 mb-4">
                        <h4 class="pb-2">LOGO</h4>
                        <p>At vero eos et accusamus et iusto 
                            odio dignissimos ducimus qui blanditiis
                             praesentium voluptatum deleniti atque 
                             corrupti quos dolores et quas molestias
                              excepturi sint occaecati cupiditate non 
                              provident, similique sunt in culpa qui officia deserunt 
                              mollitia animi, id est laborum et dolorum fuga.</p>
                        <h4 class="pt-2 pb-3">
                            Social Links
                        </h4>
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-12">
                                <a href=""><i class="fab fa-facebook fa-2x"></i></a>
                                <a href=""><i class="fab fa-twitter ps-3 fa-2x"></i></a>
                                <a href=""><i class="fab fa-instagram ps-3 fa-2x"></i></a>
                                <a href=""><i class="fab fa-youtube ps-3 fa-2x"></i></a>
                                <a href=""><i class="fab fa-linkedin ps-3 fa-2x"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                    </div>

                    <div class="col-lg-5">
                        <h4 class="pb-3">Quick Links</h4>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 1</a>
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-3">
                                <a href="">Menu 5</a>
                            </div>
                        </div>
                        
                        <div class="row">
                        <h4 class="pb-2">Help</h4>
                            <div class="col-lg-12 col-md-6 col-sm-8 col-10">
                                <a href="#">Terms and Conditions | Privacy Policy</a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <a href="#">Cookies</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark copyRight">
            <div class="col-lg-12 d-flex justify-content-center">
                <p class="pt-2">© Copyright TY Mac 2021</p>
            </div>
        </div>
</footer>
<script src="{{ asset('assets/editUser.js') }}"></script>
<script>
    let selectedTimeZone = document.getElementById('timezone').getAttribute('value');
    document.getElementById('timezone').value = selectedTimeZone;
</script>
@endsection('content')