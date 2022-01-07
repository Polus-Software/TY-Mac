@extends('Layouts.Profile')

@section('content')
    <div class="container">
        <div class="custom-container mx-auto border">
            <div class="row">                    
                <div class="col-lg-3 col-md-4 col-sm-4 col-sm-12 col-12 mt-3">
                   <div class="sidebar h-100 bg-light ms-3">
                      <div class="side-heading">
                        <p class="heading-1">My Account</p>
                       </div>
                        <ul class="nav nav-pills flex-column mb-auto mt-5">
                            <li class="nav-item">
                                <a class="nav-link link-dark" href="{{ route('edituser') }}">
                                <i class="fas fa-user pe-2"></i>
                                My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link link-dark active" href="{{ route('change.password.get') }}">
                                <i class="fas fa-lock pe-2"></i>
                                Change Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
               
                <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                    <div class="content-page">
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <form class="form" id="changePasswordForm" method="POST" action="{{ route('change.password.post') }}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                           
                            <div class="row">
                                <div class="form-group col-md-12 col-sm-12 col-12">
                                    <label for="currentPassword" class="currentPassword-label">Current Password</label>
                                    <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Current password">
                                    <span><i class="fas fa-eye-slash"  id="togglePassword" onClick="viewCurrentPass()"></i></span>
                                    <small>Error message</small>
                                    
                                    @if ($errors->has('currentPassword'))
                                        <span class="text-danger">{{ $errors->first('currentPassword') }}</span>
                                    @endif
                                </div>
                                
                                <div class="form-group col-md-12 col-sm-12 col-12">
                                    <label for="newPassword" class="newPassword-label">New Password</label>
                                    <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New password">
                                    <span><i class="fas fa-eye-slash"  id="toggleNewPassword" onClick="viewNewPass()"></i></span>
                                    <small>Error message</small>

                                    @if ($errors->has('newPassword'))
                                        <span class="text-danger">{{ $errors->first('newPassword') }}</span>
                                    @endif
                                </div>
                           
                                <div class="form-group col-md-12 col-sm-12 col-12">
                                    <label for="confirmPassword" class="confirmPassword-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Retype password">
                                    <span><i class="fas fa-eye-slash"  id="confirmTogglePassword" onClick="viewConfirmpass()"></i></span>
                                    <small>Error message</small>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                             
                               <div class="form-group buttons d-flex justify-content-end">
                                   <button type="button" class="btn back-btn">
                                   <a href="{{route('edituser')}}">Cancel</a></button>
                                   <button type="submit" class="btn update-btn">Update</button>
                               </div>
                            </div>
                        </form>    
                        
                    </div>
                </div> 
            </div>
        </div>
    </div>
<script src="{{ asset('assets/changePassword.js') }}"></script>
@endsection('content')