<div class="col-lg-12">
                <div class="think-horizontal-card mb-3 mt-5">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12 think-img-thumb-container">
                            <img src="{{asset('/storage/courseThumbnailImages/'.$courseDetails['course_thumbnail_image'])}}" class="img-fluid col-md-12 col-sm-12 col-12 card-image h-100" alt="coursepicture">
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card-body">
                                <h5 class="card-title pb-3 mb-0">
                                    {{$courseDetails['course_title']}}
                                </h5>
                                <p class="card-text think-text-color-grey position-relative">
                                <span class="think-truncated-text">
                                    {{Str::limit($courseDetails['description'], 180, '...')}}
                                </span></p>
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 mb-3">
                                    @for($i=1;$i<=5;$i++)
                                        @if($i <= $courseDetails['rating'])
                                            <i class="fas fa-star rateCourse"></i>
                                        @else
                                            <i class="far fa-star rateCourse"></i>
                                        @endif
                                        @endfor
                                            <small class="ms-1">
                                            @if($courseDetails['use_custom_ratings'] == false) 
                                                ({{ $courseDetails['ratingsCount'] }}) {{$courseDetails['studentCount']}} participants
                                            @else
                                                (10) 10 participants
                                            @endif
                                            </small>
                                        </div>
                                        <div class="col-lg-3 think-text-color-grey">
                                            <p><img class="me-1" src="/storage/icons/category__icon.svg" alt="error">
                                            {{Str::limit($courseDetails['course_category'], 15, '...')}}
                                            </p>
                                        </div>
                                        <div class="col-lg-3 col-6 col-md-3 col-sm-6 text-center text-truncate think-text-color-grey">
                                            <p class="fw-bold text-truncate"><i class="far fa-user pe-1"></i>
                                                {{$courseDetails['instructor_firstname']}} {{$courseDetails['instructor_lastname']}}
                                            </p>
                                        </div>
                                        <div class="col-lg col-md-3 col-sm-4 col-12 d-flex justify-content-end ps-0 text-end think-text-color-grey">
                                            <p class="fw-bold text-truncate"><img class="me-1" src="/storage/icons/level__icon.svg" alt="error">       
                                                {{$courseDetails['course_difficulty']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6 think-text-color-grey">
                                            <p class="fw-bold text-truncate"><i class="far fa-clock pe-1"></i>{{$courseDetails['duration']}}</p>
                                        </div>
                                       
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>