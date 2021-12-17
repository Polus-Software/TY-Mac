<!-- sidebar -->
<div class="d-flex flex-column flex-shrink-0 bg-light">
  <ul class="nav nav-pills flex-column mb-auto mt-5 llp-sidebar">
    <li class="nav-item">
      <a class="nav-link link-dark" href="">
      Status: <span class="badge bg-warning text-dark">Draft</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark text-uppercase pe-none" href="">
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('view-course', ['course_id' => $course_id]) }}">
      <i class="fas fa-clipboard-list"></i>
        Course Overview</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('view-subtopics', ['course_id' => $course_id]) }}">
      <i class="fas fa-book-reader"></i>
        Sub topics</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('view-assignment', ['course_id' => $course_id]) }}">
      <i class="fas fa-users"></i>
        Assignments</a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark" href="{{ route('view_cohortbatches', ['course_id' => $course_id]) }}">
      <i class="fas fa-user-friends"></i>
        Cohorts</a>
    </li>
    <li class="nav-item" style="margin-top: auto;">
    <a class="btn btn-primary">Publish</a>
    </li>
    <li class="nav-item" style="margin-top: auto;">
    <a class="btn btn-outline-secondary" href="{{ route('manage-courses') }}">Back to course list</a>
    </li>
  </ul>
</div>
<!-- sidebar ends -->
