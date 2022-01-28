@php

  use App\Models\Notification;
  $user = Auth::user();

  if($user) {
    $notifications = Notification::where('user', $user->id)->orderBy('created_at', 'DESC')->get();
    $newNotifications = Notification::where('user', $user->id)->where('is_read', false)->get();
    $notificationCount = count($newNotifications);
  }
  @endphp
<!-- navbar new  -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm p-3 mb-5 bg-body think-navbar">
    <div class="container">
      <a class="navbar-brand" href="/"><img src="/storage/logo/ty_mac__vector.svg"></img></a>
      <button class="navbar-toggler nav-bar-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      @if(Auth::check())  
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6 col-md-9 col-sm-9 col-6">
        @csrf
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search-box">
        <button class="btn btn-outline-dark" type="button" id="search-btn">Search</button>
      </form>
      @else
      <div class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6 col-md-9 col-sm-9 col-6"></div>
      @endif
      
    
    <ul class="navbar-nav mx-0 think-custom-nav-1">
    @if (Auth::check())
      @if(Auth::user()->role_id !== Config::get('common.ROLE_ID_INSTRUCTOR'))      
        <li class="nav-item {{ (request()->is('/')) ? 'active': '' }}">
          <a class="nav-link" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item {{ (request()->is('thinklitway')) ? 'active': '' }}">
          <a class="nav-link" aria-current="page" href="{{ route('thinklitway') }}">The Thinklit Way</a>
        </li>
        <li class="nav-item {{ (request()->is('student-courses')) ? 'active': '' }}">
          <a class="nav-link" href="{{ route('student.courses.get') }}">Courses</a>
        </li>
        @endif
        @else
        <li class="nav-item {{ (request()->is('/')) ? 'active': '' }}">
          <a class="nav-link" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item {{ (request()->is('thinklitway')) ? 'active': '' }}">
          <a class="nav-link" aria-current="page" href="{{ route('thinklitway') }}">The Thinklit Way</a>
        </li>
        <li class="nav-item {{ (request()->is('student-courses')) ? 'active': '' }}">
          <a class="nav-link" href="{{ route('student.courses.get') }}">Courses</a>
        </li>
        @endif
      @if (Auth::check())
        @if(Auth::user()->role_id == Config::get('common.ROLE_ID_INSTRUCTOR'))
        <li class="nav-item {{ (request()->is('assigned-courses')) ? 'active': '' }}">
          <a class="nav-link" href="{{ route('assigned-courses') }}">Assigned Courses</a>
        </li>
        @else
        <li class="nav-item {{ (request()->is('my-courses')) ? 'active': '' }}">
          <a class="nav-link" href="{{ route('my-courses') }}">My courses</a>
        </li>
        @endif
        <li class="nav-item">
        <a class="nav-link" href="{{ route('edituser') }}">
        <img src="{{ asset('/storage/images/'.Auth::user()->image) }}" class="img-fluid rounded-circle float-start me-2" alt="" style="width:20px; height:20px;">{{Auth::user()->firstname}}</a>
      </li>
      <li>

          <button type="button" class="btn dropdown-toggle-split shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
            <!-- <span class="visually-hidden">Toggle Dropdown</span> --><i class="fas fa-bell"></i><span class="notifications_count">{{ $notificationCount }}</span>
          </button>
          
          <ul id="notification_drop" class="dropdown-menu">
            <h6 class="p-2">Notifications</h6>
            @foreach($notifications as $notification)
            <li><hr class="dropdown-divider"></li>
            <li><a class="notification-item dropdown-item p-2" href="#"><i class="fas fa-dot-circle notification-dot"></i> <span>{{$notification->notification}}<span></a></li>
            @endforeach
          </ul>

      </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @else                
        <li class="nav-item">
        <a id="signup_navlink" class="nav-link" href="#signup" data-bs-toggle="modal" data-bs-target="#signupModal"><span class="me-2"><img src="/storage/icons/signup__icon.svg" alt="error"></span>Sign Up</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="login_navlink" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal"><span class="me-2"><img src="/storage/icons/login__icon.svg" alt="error"></span>Login</a></li>
        </li>
        @endif
    </ul>
    </div>
    </div>
  </nav>
  @if(Auth::check()) 
  <script>
    
document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});
document.getElementById("search-box").addEventListener("keyup", function(e) {
  if(e.which == 13) {
    e.preventDefault();
    let searchTerm = document.getElementById('search-box').value;
    let path = "/course-search?search=" + searchTerm;
    window.location = '/course-search?search=' + searchTerm;
  }

});

    </script>
    @endif
  <!-- navbar new ends -->