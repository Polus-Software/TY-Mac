<!-- sidebar -->
<div class="bg-light d-flex flex-column justify-content-between flex-shrink-0 llp-sidebar">
  <ul class="nav nav-pills flex-column mb-auto mt-5">
    <li class="nav-item">
      <a class="nav-link link-dark" href="">
      Status: <span class="badge bg-warning text-dark">Draft</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark text-uppercase pe-none" href="">
    </li>
    <li class="nav-item">
    @if(Route::current()->getName() == 'edit-course')
    <a class="nav-link link-dark" href="{{ route('view-course',$course_id) }}">
    @else
    <a class="nav-link link-dark" href="{{ route('add-course') }}">
    @endif
    <i class="fas fa-clipboard-list"></i>Course Overview</a>
    </li>
    <li class="nav-item">
    @if(Route::current()->getName() == 'edit-course')
    <a class="nav-link link-dark" role="button" href="{{ route('view-subtopics', ['course_id' => $course_id]) }}">
    @elseif(Route::current()->getName() == 'add-course')
    <a class="nav-link link-dark disabled" role="button" aria-disabled="true" href="#">
    @else
    <a class="nav-link link-dark disabled" role="button" aria-disabled="true" href="{{ route('view-subtopics', ['course_id' => $course_id]) }}">
    @endif
    <i class="fas fa-book-reader"></i>Sub topics</a>
    </li>
    <li class="nav-item">
    @if(Route::current()->getName() == 'edit-course')
    <a class="nav-link link-dark" href="{{ route('view-assignments', $course_id) }}">
    @elseif(Route::current()->getName() == 'add-course')
    <a class="nav-link link-dark disabled" role="button" aria-disabled="true" href="#">
    @else
    <a class="nav-link link-dark disabled" role="button" aria-disabled="true" href="{{ route('view-assignments', $course_id) }}">
    @endif
    <i class="fas fa-users"></i>Assignments</a>
    </li>
    <li class="nav-item">
    @if(Route::current()->getName() == 'edit-course')
    <a class="nav-link link-dark" href="{{ route('view-cohort', ['course_id' => $course_id]) }}">
    @elseif(Route::current()->getName() == 'add-course')
    <a class="nav-link link-dark disabled" role="button" aria-disabled="true" href="#">
    @else
    <a class="nav-link link-dark disabled" role="button" aria-disabled="true" href="{{ route('view-cohort', ['course_id' => $course_id]) }}">
    @endif
     <i class="fas fa-user-friends"></i>Cohorts</a>
    </li>    
  </ul>
  <div class="position-relative btn-bottom-container">
    @csrf
    <a class="btn btn-primary d-block" id="publish">Publish</a>
    <a class="btn btn-outline-secondary d-block mt-2" href="{{ route('manage-courses') }}">Back to course list</a>
  </div>
</div>
<!-- sidebar ends -->


