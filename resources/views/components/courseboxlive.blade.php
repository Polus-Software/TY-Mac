<div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
    <div class="card-1">
        @if($page ==='assigned')
        <img src="/storage/courseThumbnailImages/{{ $course['image'] }}" class="card-img-top think-img-h" alt="...">
        @else
        <img src="/storage/courseThumbnailImages/{{ $course['course_thumbnail_image'] }}" class="card-img-top think-img-h" alt="...">
        @if($cardtype === 'live')
        <span class="badge text-danger border border-1 border-danger position-absolute start-0 top-0 ms-3 mt-3 bg-white">Live</span>
        @endif
        @endif
        <div class="card-body">
            <h5 class="card-title text-center text-truncate" title="{{ $course['session_title'] }}">{{ $course['session_title'] }}</h5>
            <p class="card-text text-sm-start position-relative">
                <span class="think-truncated-text">
                    {{Str::limit($course['course_desc'], 180, '...')}}
                </span>
            </p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <p><i class="far fa-user pe-1"></i>{{ $course['instructor'] }}</p>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6">
                            <p class="text-end"><img src="/storage/icons/level__icon.svg" class="me-1"> {{ $course['course_diff'] }}</p>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="row">
                <div class="text-center border-top">
                    @if($cardtype !== 'live')
                    <a href="/enrolled-course/{{ $course['course_id'] }}?batchId={{ $course['batchId'] }}" class="card-link btn w-100">Go to details</a>
                    @else
                    <a href="/session-view/{{ $course['id'] }}?batchId={{ $course['batchId'] }}" class="card-link btn">Join now</a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
