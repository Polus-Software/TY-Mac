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

/* section .card-2{
    border: 1px solid #E0E0E0 !important;
    border-radius: 10px;
    background:#fff;
    outline: 1px solid #AF7E00;
    cursor: pointer;
}

section .card-2:hover, .card-2:active, .card-2.active-batch{
    border: 1px solid #E0E0E0 !important;
    border-radius: 10px;
    background:#FFF9E8;
    outline: 1px solid #AF7E00;
    cursor: pointer;
} */

  </style>
<header class="d-flex align-items-center mb-3">
    <div class="container">
        <div class="row mt-5">
        <x-courseboxmd :courseDetails="$courseDetails"></x-courseboxmd>
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
        @if(!empty($singleCourseDetails))
        @foreach($singleCourseDetails as $singleCourseDetail)
            @php ($active_class = 'inactive')
        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-4">
            @if($singleCourseDetail['available_count'] > 0)
                @php ($active_class = 'active')
            @endif
            @if ($loop->first)
            <div class="card-2 text-center active active-batch" style="width: auto;">
            @else
                <div class="card-2 text-center {{$active_class}}" style="width: auto;">
            @endif
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
                        @if($singleCourseDetail['available_count'] > 0)
                            <p class="think-register-card-title think-tertiary-color">Available slots: {{$singleCourseDetail['available_count']}}</p>
                        @else
                            <p class="think-register-card-title think-tertiary-color">No slot available</p>
                        @endif
                    </div>
            </div>
        </div>
        @endforeach
        @else
        <x-nodatafound message="No batches available"  notype="" />
        @endif
    </div>
    <div class="row mt-4 mb-4">
        <div class="buttons d-flex justify-content-end mt-2">
            @csrf
            @if(empty($singleCourseDetails))
            <button type="submit" id="registerNowButton" class="btn btn-secondary think-btn-secondary disabled">Register Now</button>
            @else
            <button type="submit" id="registerNowButton" class="btn btn-secondary think-btn-secondary">Register Now</button>
            @endif
            <input type="hidden" id="course_id" value="{{$courseDetails['course_id']}}">
        </div>
    </div>
</div>
</section>
@endsection('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('/assets/enrollcourse.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/enrolledCoursePage.css') }}">
@endpush
@push('child-scripts')
<script>
//document.getElementsByClassName('card-2')[0].classList.add('active-batch');
    document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});

    let cards = document.getElementsByClassName('active');
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