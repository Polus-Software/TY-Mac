@extends('Layouts.app')
@section('content')
<style>
  .btn-outline-success {
    border-color: #000000 !important;
}
.btn-outline-success:hover {
  background-color: #fff !important;
  border-color: #000000 !important;
  color: #000000 !important;
}
.card-2:hover {
    cursor: pointer;
}
  </style>

    <section class="pt-5">
        <div class="container">
            <div class="row border-bottom mt-5 pb-3">
                <div class="col-lg-6 col-md-6 col-sm-7 col-12">
                    <h3>Current Live Classes</h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-5 col-12 d-flex  justify-content-lg-end justify-content-md-end justify-content-sm-end">
                    <ul class="nav nav-tabs border border-dark">
                        <li class="nav-item active">
                            <button class="nav-link active" id="live-tab" type="button" data-bs-toggle="tab"
                                data-bs-target="#live" role="tab" aria-controls="live" aria-selected="true"
                                data-bs-toggle="tab">Live</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="upcoming-tab" type="button" data-bs-toggle="tab"
                                data-bs-target="#upcoming" role="tab" aria-controls="upcoming" aria-selected="false"
                                data-bs-toggle="tab">Upcoming</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>




    <section class="mt-4">
        <div class="container">
            <div class="row">
                <div class="tab-content">
                    <div id="live" class="tab-pane fade show active" aria-labelledby="live-tab">
                        <div class="col-lg-12">
                            <div id="liveCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            @forelse($liveSessionDetails as $liveSessionDetail)
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">{{ $liveSessionDetail['session_title'] }}</h5>
                                                        <p class="card-text text-sm-start position-relative">
                                                            <span class="think-truncated-text">
                                                                {{Str::limit($liveSessionDetail['course_desc'], 180, '...')}}
                                                            </span>
                                                        </p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i> {{ $liveSessionDetail['instructor'] }}</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> {{ $liveSessionDetail['course_diff'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Join now</a>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                <x-nodatafound message="No live classes at the moment!"  notype="video" />
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                
                                    <button class="carousel-control-prev" type="button" data-bs-target="#liveCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#liveCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                
                               
                            </div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                    <div id="upcoming" class="tab-pane fade" aria-labelledby="upcoming-tab">
                        <div class="col-lg-12">
                            <div id="upcomingCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            
                                          @forelse($upComingSessionDetails as $upComingSessionDetail)
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-4">
                                                <div class="card-1">
                                                    <img src="courselist/Illustration/Mask Group 2.jpg"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">{{ $upComingSessionDetail['session_title'] }}</h5>
                                                        <p class="card-text text-sm-start position-relative">
                                                            <span class="think-truncated-text">
                                                                {{Str::limit($upComingSessionDetail['course_desc'], 180, '...')}}
                                                            </span>
                                                        </p>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p><i class="far fa-user pe-1"></i>{{ $upComingSessionDetail['instructor'] }}</p>
                                                                    </div>
                                                                    <div class="col-lg-6 col-sm-6 col-6">
                                                                        <p class="text-end"><i
                                                                                class="far fa-user pe-1"></i> {{ $upComingSessionDetail['course_diff'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row bg-light">
                                                            <div class="text-center border-top">
                                                                <a href="" class="card-link btn">Go to details</a>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                <x-nodatafound message="No upcoming classes at the moment!"  notype="video" />
                                            @endforelse                                            
                                        </div>
                                    </div>

                                    
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#upcomingCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#upcomingCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                
                            </div>
                        </div>
                    </div>
</div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <div class="container">
            <div class="row border-bottom pb-3">
                <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-start">
                    <h3>My Courses</h3>
                </div>
                <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-end">
                    <select name="" id="" class="rounded pe-4">
                        <option value="most-popular">Course in progress</option>
                    </select>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-lg-12">
                    @foreach ($singleEnrolledCourseData as $singleEnrolledCourse)
                        <div class="card-2 mb-3 mt-4" data-id="{{ $singleEnrolledCourse['course_id'] }}">
                            <div class="row g-0">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <img src="{{ asset('/storage/courseImages/' . $singleEnrolledCourse['course_image']) }}"
                                        class="img-fluid coursepicture col-md-12 col-sm-12 col-12 h-100"
                                        alt="coursepicture">
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="card-body">
                                        <h5 class="card-title pb-3">
                                            {{ $singleEnrolledCourse['course_title'] }}
                                        </h5>
                                        <p class="card-text position-relative">
                                        <span class="think-truncated-text">
                                        {{Str::limit($singleEnrolledCourse['description'], 180, '...')}}
                                        </span>
                                        </p>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                                <div class="progress rounded-pill">
                                                    <div class="progress-bar rounded-pill text-end pe-2" role="progressbar"
                                                        style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                                                        aria-valuemax="100">25%</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><img class="me-1" src="/storage/icons/category__icon.svg" alt="error">
                                                    {{ $singleEnrolledCourse['category_name'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-12">
                                                <p class="para-1"><i class="far fa-user pe-1"></i>
                                                    {{ $singleEnrolledCourse['instructor_firstname'] }}
                                                    {{ $singleEnrolledCourse['instructor_lastname'] }}
                                                </p>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                                                <p class="para-2"><i class="far fa-user pe-1"></i>
                                                    {{ $singleEnrolledCourse['course_difficulty'] }}
                                                </p>
                                            </div>
                                            
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                               
                                                <p class="duration"><i class="far fa-clock pe-1"></i>Next cohort:
                                                 <small> {{ $singleEnrolledCourse['start_date'] }}
                                                    </small>
                                                </p>
                                                
                                                
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



        </div>

    </section>


    
@endsection('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('/assets/myCourses.css') }}">
@endpush
@push('child-scripts')
<script>
document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});

    var elements = document.getElementsByClassName('card-2');
    var length = elements.length;
    for(index=0;index<length;index++) {
        console.log(elements[index]);
        elements[index].addEventListener('click', function(event) {
            let courseId = this.getAttribute('data-id');
            window.location.href = "/choose-cohort?id=" + courseId;
        });
    }

    document.getElementById('upcoming-tab').addEventListener('click', function(e){
        document.getElementById('upcoming').classList.add('active', 'show');
        document.getElementById('live').classList.remove('active', 'show');
    });

    document.getElementById('live-tab').addEventListener('click', function(e){
        document.getElementById('upcoming').classList.remove('active', 'show');
        document.getElementById('live').classList.add('active', 'show');
    });
</script>
@endpush
