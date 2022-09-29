<div class="card-1">
                    <img src="/storage/courseThumbnailImages/{{ ($course['course_thumbnail_image']) ?  $course['course_thumbnail_image'] : 'defaultImage.png'}}" class="card-img-top" alt="{{ $course['course_title'] }}">
                    <div class="card-body pb-0 fs-14">
                      <h5 class="card-title text-center text-truncate fs-16 fw-bold">{{ $course['course_title'] }}</h5>
                      <p class="card-text text-sm-start text-truncate">{{ $course['description'] }}</p>


                      <div class="row mb-3">
                        <div class="col-lg-6 col-sm-6 col-6">
                          @for($i = 1; $i <= 5; $i++) @if($i <=$course['rating']) <i class="fas fa-star rateCourse"></i>
                            @else
                            <i class="far fa-star rateCourse"></i>
                            @endif
                            @endfor
                            @if($course['use_custom_ratings'] == false) 
                                ({{ $course['ratingsCount'] }})
                            @else
                                (10)
							              @endif
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">
                          <img class="me-1 think-w-14_5" src="/storage/icons/category__icon.svg" alt="error">{{ $course['course_category'] }}
                        </div>
                      </div>

                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                          <div class="row">
                            <div class="col-auto item-1 px-0"><i class="far fa-clock pe-1"></i>{{ $course['duration'] }}</div>
                            <div class="col item-2 px-0 text-center">
                              <p class="think-text-color-grey fw-bold"><i class="far fa-user pe-1"></i>{{ $course['instructor_firstname'] ." ". $course['instructor_lastname']}}</p>
                            </div>
                            <div class="col-auto item-3 px-0 d-flex">
                              <p class="think-text-color-grey fw-bold text-end"><img class="me-1" src="/storage/icons/level__icon.svg" alt="error">{{ $course['course_difficulty'] }}</p>
                            </div>
                          </div>
                        </li>
                      </ul>
                      <div class="row py-2">
                        <div class="text-center border-top">
                          <a href="{{ route('student.course.show', $course['id'])}}" class="card-link btn d-inline-block w-100 px-0">Go to details</a>
                        </div>
                      </div>

                    </div>
                  </div>