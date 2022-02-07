<!-- sidebar -->
<div class="bg-light d-flex flex-column justify-content-between flex-shrink-0 llp-sidebar">
  <ul class="nav nav-pills flex-column mb-auto mt-5">
    <li class="nav-item">
      <a class="nav-link link-dark" href="">
        Status:
        @if($courseStatus == 0)
        <span class="badge bg-warning text-dark">Draft</span>
        @else
        <span class="badge bg-success text-dark">Published</span>
        @endif
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link link-dark text-uppercase pe-none" href="">
    </li>
    <li class="nav-item"><a class="nav-link link-dark" 
    href="{{ (Route::current()->getName() == 'view-course' || Route::current()->getName() == 'edit-course' || Route::current()->getName() == 'add-course') ? '#' : route('view-course', ['course_id' => $course_id])}}">
        <i class="fas fa-clipboard-list"></i>Course Overview</a></li>
    <li class="nav-item"><a class="nav-link link-dark"
    href="{{ (Route::current()->getName() == 'view-subtopics' || Route::current()->getName() == 'edit-subtopics' || Route::current()->getName() == 'add-course') ? '#' : route('view-subtopics', ['course_id' => $course_id])}}">
    <i class="fas fa-clipboard-list"></i>Topics</a></li>
    <li class="nav-item"><a class="nav-link link-dark"
    href="{{ (Route::current()->getName() == 'view-assignments' || Route::current()->getName() == 'edit-assignments' || Route::current()->getName() == 'add-course') ? '#' : route('view-assignments', ['course_id' => $course_id])}}">
      <i class="fas fa-clipboard-list"></i>Assignments</a></li>
    <li class="nav-item"><a class="nav-link link-dark"
    href="{{ (Route::current()->getName() == 'view_cohortbatches' || Route::current()->getName() == 'edit-cohort' || Route::current()->getName() == 'add-course') ? '#' : route('view_cohortbatches', ['course_id' => $course_id])}}">
      <i class="fas fa-clipboard-list"></i>Cohorts</a></li>
  </ul>
  <div class="position-relative btn-bottom-container">
    @if($courseStatus == 0)
    <a class="btn btn-primary d-block" id="publish">Publish</a>
    @else
    <a class="btn btn-primary d-block" id="publish">Unpublish</a>
    @endif

    <a class="btn btn-outline-secondary d-block mt-2" href="{{ route('manage-courses') }}">Back to course list</a>
  </div>
</div>
<!-- sidebar ends -->

<script>
  document.getElementById('publish').addEventListener('click', function(e) {
    let courseId = document.getElementById('course_id').value;
    if (courseId == null) {
      return false;
    } else {
      let path = "{{ route('publish-course') }}?course_id=" + courseId
      fetch(path, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          "X-CSRF-Token": document.querySelector('input[name=_token]').value
        },
        body: JSON.stringify({})
      }).then((response) => response.json()).then((data) => {
        if (data.status == 'published') {
          document.getElementById('publish').innerHTML = "Unpublish";
          document.getElementById('publish-badge').innerHTML = "Published"
          document.getElementById('publish-badge').classList.remove('bg-warning');
          document.getElementById('publish-badge').classList.add('bg-success');
        } else {
          document.getElementById('publish').innerHTML = "Publish";
          document.getElementById('publish-badge').innerHTML = "Draft"
          document.getElementById('publish-badge').classList.remove('bg-success');
          document.getElementById('publish-badge').classList.add('bg-warning');
        }
      });
    }
  });
</script>