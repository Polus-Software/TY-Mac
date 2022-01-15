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
  </style>
<header class="d-flex align-items-center mb-3">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="think-horizontal-card mb-3 mt-5">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <img src="{{asset('/storage/courseThumbnailImages/'.$courseDetails['course_thumbnail_image'])}}" class="img-fluid col-md-12 col-sm-12 col-12 card-image h-100" alt="coursepicture">
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card-body">
                                <h5 class="card-title pb-3 mb-0">
                                    {{$courseDetails['course_title']}}
                                </h5>
                                <p class="card-text think-text-color-grey"> {{$courseDetails['description']}}</p>
                                <div class="row">
                                    <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i><small class="ms-1">(60 ratings) 100 participants</small>
                                        </div>
                                        <div class="col-sm-auto col-6 think-text-color-grey">
                                            <p><img class="me-1" src="/storage/icons/category__icon.svg" alt="error">
                                                {{$courseDetails['course_category']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6 think-text-color-grey text-truncate">
                                            <p class="fw-bold"><i class="far fa-user pe-1"></i>
                                                {{$courseDetails['instructor_firstname']}} {{$courseDetails['instructor_lastname']}}
                                            </p>
                                        </div>
                                        <div class="col-sm-auto col-6 think-text-color-grey">
                                            <p class="fw-bold"><img class="me-1" src="/storage/icons/level__icon.svg" alt="error">       
                                                {{$courseDetails['course_difficulty']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6 think-text-color-grey">
                                            <p class="fw-bold"><i class="far fa-clock pe-1"></i>{{$courseDetails['duration']}} h</p>
                                        </div>
                                       
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section>
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="border-bottom pb-3">Choose Your Cohort</h1>
        </div>
    </div>
    <div class="row">
        @foreach($singleCourseDetails as $singleCourseDetail)
        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-4">
            <div class="card-2 text-center" style="width: auto;">
               <input type="hidden" id="batch_id" value="{{$singleCourseDetail['batch_id']}}">
                    <div class="card-body">
                        <i class="far fa-calendar-alt pb-3"></i>
                        <p class="think-register-card-title think-tertiary-color">{{$singleCourseDetail['batchname']}}</p>
                        <p class="card-text-1 mb-1">Cohort starts - {{$singleCourseDetail['start_date']}}</p>
                        <p class="card-text-1 mb-1 fs-14">{{$singleCourseDetail['title']}}</p>
                        <p class="card-text">
                            {{$singleCourseDetail['start_time']}} {{$singleCourseDetail['time_zone']}} - {{$singleCourseDetail['end_time']}}
                            {{$singleCourseDetail['time_zone']}}
                        </p>
                    
                    </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row mt-4 mb-4">
        <div class="form-group buttons d-flex justify-content-end">
            @csrf
            <button type="submit" id="registerNowButton" class="btn btn-secondary think-btn-secondary">Register Now</button>
            <input type="hidden" id="course_id" value="{{$courseDetails['course_id']}}">
        </div>
    </div>
</div>
</section>
@endsection('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('/assets/enrolledCoursePage.css') }}">
@endpush
@push('child-scripts')
<script>
    document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});

    let cards = document.getElementsByClassName('card-2');
    for(var index = 0; index < cards.length; index++) {
        cards[index].addEventListener('click', function (event){
            this.classList.add("active-batch");
            for(var index = 0; index < cards.length; index++) {
                if (cards[index]!=this) {
                    console.log(cards[index]);
                    cards[index].classList.remove("active-batch");
                }
            }
    });
}

document.getElementById('registerNowButton').addEventListener('click', (event) => {

     let courseId = document.getElementById('course_id').value;
     let activeBatch = document.getElementsByClassName('active-batch')[0].children[0];
     let batchId = activeBatch.value;
     let path = "{{ route('student.course.register.post') }}?course_id=" + courseId + '&batch_id=' + batchId;
     
     fetch(path, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]').value
            },
           body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
            if (data.status =='success'){
               window.location.href ="/enrolled-course/"+ courseId;
            }
            
        });
});

</script>
@endpush