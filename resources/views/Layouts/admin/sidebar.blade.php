<!-- sidebar -->
<div class="d-flex flex-column flex-shrink-0 bg-light">
  <ul class="nav nav-pills flex-column mb-auto mt-5 llp-sidebar">
    <li class="nav-item">
      <a class="nav-link link-dark active" href="{{ route('dashboard') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#speedometer2" />
        </svg>
        Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark text-uppercase pe-none" href="{{ route('manage-course-categories') }}">Management</a>
    </li>
    @if($userType == 'content_creator')
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-course-categories') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-courses') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Courses</a>
    </li>
    @elseif($userType == 'admin')
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('admin.viewall') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#people-circle" />
        </svg>
        Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-instructors') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#people-circle" />
        </svg>
        Instructors</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-creators') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#people-circle" />
        </svg>
        Content Creators</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-course-categories') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Course Categories</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('manage-courses') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Courses</a>
    </li>
    @elseif($userType == 'instructor')
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('instructor-session-view') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        View Scheduled Sessions</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="#">Change Password</a>
    </li>
    @else
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('instructor-session-view') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Attend Session</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="#">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        Change Password</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('student.courses.get') }}">
        <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table" />
        </svg>
        courses</a>
    </li>
    @endif

  </ul>
</div>
<!-- sidebar ends -->
