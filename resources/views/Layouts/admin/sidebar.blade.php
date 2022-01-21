<!-- sidebar -->

<div class="d-flex flex-column flex-shrink-0 bg-light">
  <ul class="nav nav-pills flex-column mb-auto mt-5 llp-sidebar">
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'dashboard' ? 'active' : ''}}" href="{{ route('dashboard') }}">
      <i class="fas fa-home"></i>
        Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark text-uppercase pe-none" href="{{ route('manage-course-categories') }}">Management</a>
    </li>
    @if($userType == 'content_creator')
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-courses' ? 'active' : ''}}" href="{{ route('manage-courses') }}">
      <i class="fas fa-clipboard-list"></i>
        Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-courses' ? 'active' : ''}}" href="{{ route('manage-courses') }}">
      <i class="fas fa-book-reader"></i>
        Courses</a>
    </li>
    @elseif($userType == 'admin')
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'attendance.tracker.view' ? 'active' : ''}}" href="{{ route('attendance.tracker.view') }}">
      <i class="fas fa-graduation-cap"></i>
        Attendance Tracker</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'admin.viewall' ? 'active' : ''}}" href="{{ route('admin.viewall') }}">
      <i class="fas fa-users"></i>
        Students</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-instructors' ? 'active' : ''}}" href="{{ route('manage-instructors') }}">
      <i class="fas fa-user-friends"></i>
        Instructors</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-creators' ? 'active' : ''}}" href="{{ route('manage-creators') }}">
      <i class="fas fa-users-cog"></i>
        Content Creators</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-admin' ? 'active' : ''}}" href="{{ route('manage-admin') }}">
      <i class="fas fa-users-cog"></i>
        Admin Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-course-categories' ? 'active' : ''}}" href="{{ route('manage-course-categories') }}">
      <i class="fas fa-clipboard-list"></i>
        Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'manage-courses' ? 'active' : ''}}" href="{{ route('manage-courses') }}">
      <i class="fas fa-book-reader"></i>
        Courses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'schedule-session' ? 'active' : ''}}" href="{{ route('schedule-session') }}">
      <i class="fas fa-book-reader"></i>
        Schedule Live Session</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'admin-settings' ? 'active' : ''}}" href="{{ route('admin-settings') }}">
      <i class="fas fa-cogs"></i>
        App Settings</a>
    </li>
    @elseif($userType == 'instructor')
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'sessions-view' ? 'active' : ''}}" href="{{route('sessions-view')}}">
        View Scheduled Sessions</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'change.password.get' ? 'active' : ''}}" href="{{ route('change.password.get') }}">Change Password</a>
    </li>

    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'assigned-courses' ? 'active' : ''}}" href="{{ route('assigned-courses') }}">Assigned Courses</a>
    </li>
    @else
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'change.password.get' ? 'active' : ''}}" href="{{ route('change.password.get') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Change Password</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark {{ Route::currentRouteName() == 'student.courses.get' ? 'active' : ''}}" href="{{ route('student.courses.get') }}">
      <i class="fas fa-book-reader"></i>
        Courses</a>
    </li>
    @endif

  </ul>
</div>
<!-- sidebar ends -->


<script>

  let navLink = document.getElementsByClassName('nav-link');
  let navLinkLength = navLink.length;

  for(index = 0; index < navLinkLength; index++) {
    navLink[index].addEventListener('click', function(e) {
        // this.classList.add('active');
    });
  }
</script>