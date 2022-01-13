<!-- navbar new  -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm p-3 mb-5 bg-body think-navbar">
    <div class="container">
      <a class="navbar-brand" href="#">TY-Mac</a>
      <button class="navbar-toggler nav-bar-light bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      @if(Auth::check())  
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6 col-md-9 col-sm-9 col-6">
        @csrf
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search-box">
        <button class="btn btn-outline-success" type="button" id="search-btn">Search</button>
      </form>
      @else
      <div class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6 col-md-9 col-sm-9 col-6"></div>
      @endif
      
    
    <ul class="navbar-nav mx-0 think-custom-nav-1">      
      <li class="nav-item {{ (request()->is('/')) ? 'active': '' }}">
        <a class="nav-link" aria-current="page" href="/">Home</a>
      </li>
      <li class="nav-item {{ (request()->is('student-courses')) ? 'active': '' }}">
        <a class="nav-link" href="{{ route('student.courses.get') }}">All Courses</a>
      </li>
      @if (Auth::check())
        @if(Auth::user()->role_id == 3)
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
        <img src="{{ asset('/storage/images/'.Auth::user()->image) }}" class="img-fluid rounded-circle float-start me-2 mt-1" alt="" style="width:20px; height:20px;">{{Auth::user()->firstname}}</a>
      </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item"><a class="nav-link" href="#testimonials">Apply to be an instructor</a></li>        
        <li class="nav-item">
        <a id="signup_navlink" class="nav-link" href="#signup" data-bs-toggle="modal" data-bs-target="#signupModal"><span class="me-2"><img src="/icons/signup__icon.svg" alt="error"></span>Signup</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal"><span class="me-2"><img src="/icons/login__icon.svg" alt="error"></span>Login</a></li>
        </li>
        @endif
    </ul>
    </div>
    </div>
  </nav>

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
  <!-- navbar new ends -->