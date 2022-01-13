<!-- header -->

<nav class="navbar navbar-expand-lg navbar-light bg-light llp-header position-fixed w-100">
  <div class="container">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- <form class="d-flex me-auto">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>  -->

      <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('edituser') }}" title="View profile">
         
           <img src="{{ asset('/storage/images/'.Auth::user()->image) }}" class="img-fluid rounded-circle float-start me-2" alt="" style="width:20px; height:20px;">
          
         <!-- <i class="fas fa-user-circle"></i> -->
         
            {{Auth::user()->firstname}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
            logout</a>
        </li>
      </ul>

    </div>
  </div>
</nav>
<!-- header ends -->
