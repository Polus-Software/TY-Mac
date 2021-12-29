<!-- sidebar -->
<div class="d-flex flex-column flex-shrink-0 bg-light">
  <ul class="nav nav-pills flex-column mb-auto mt-5 llp-sidebar">
    <li class="nav-item">
      <a class="nav-link link-dark active" href="{{ route('dashboard') }}">
      <i class="fas fa-home"></i>
        Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark text-uppercase pe-none" href="{{ route('manage-course-categories') }}">Management</a>
    </li>
    @if($userType == 'content_creator')
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-course-categories') }}">
      <i class="fas fa-clipboard-list"></i>
        Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-courses') }}">
      <i class="fas fa-book-reader"></i>
        Courses</a>
    </li>
    @elseif($userType == 'admin')
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('admin.viewall') }}">
      <i class="fas fa-users"></i>
        Students</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-instructors') }}">
      <i class="fas fa-user-friends"></i>
        Instructors</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-creators') }}">
      <i class="fas fa-users-cog"></i>
        Content Creators</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-course-categories') }}">
      <i class="fas fa-clipboard-list"></i>
        Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-courses') }}">
      <i class="fas fa-book-reader"></i>
        Courses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('schedule-session') }}">
      <i class="fas fa-book-reader"></i>
        Schedule Live Session</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('admin-settings') }}">
      <i class="fas fa-cogs"></i>
        App Settings</a>
    </li>
    @elseif($userType == 'instructor')
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{route('sessions-view')}}">
        <!-- <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg> -->
        View Scheduled Sessions</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="#">Change Password</a>
    </li>

    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('assigned-courses') }}">Assigned Courses</a>
    </li>
    @else
    <!-- <li class="nav-item">
      <a class="nav-link link-dark" href="">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        View Sessions</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link link-dark" href="#">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Change Password</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('student.courses.get') }}">
      <i class="fas fa-book-reader"></i>
        Courses</a>
    </li>
    @endif

  </ul>
</div>
<!-- sidebar ends -->
<!-- <section>
<div class="tab-content" id="v-pills-tabContent">
<div class="tab-pane fade" id="v-pills-assignedCourses" role="tabpanel" aria-labelledby="v-pills-assignedCourses-tab">
  <h1>sfnkjvbgikf</h1>
</div>
</div>
</section> -->
