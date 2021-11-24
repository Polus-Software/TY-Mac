
@extends('Layouts.enrollCourse')
@section('content')
<header class="d-flex align-items-center mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-1 mb-3 mt-4">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <img src="{{asset('/storage/images/'.$courseDetails['course_image'])}}" class="img-fluid col-md-12 col-sm-12 col-12 card-image" alt="coursepicture">
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card-body">
                                <h5 class="card-title pb-3">
                                    {{$courseDetails['course_title']}}
                                </h5>
                                <p class="card-text">By learning both of these apps, 
                                    you will gain valuable productivity skills & become more efficient at creating documents, spreadsheets, 
                                    and presentations.</p>
                                <div class="row">
                                    <div class="col-lg-5 col-md-12 col-sm-12 col-12 mb-3">
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i><small>(60 ratings) 100 participants</small>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                            <p><i class="fas fa-tag fa-flip-horizontal ps-1"></i>
                                                {{$courseDetails['course_category']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                            <p><i class="far fa-user pe-1"></i>
                                                {{$courseDetails['instructor_firstname']}} {{$courseDetails['instructor_lastname']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                            <p><i class="far fa-user pe-1"></i>        
                                                {{$courseDetails['course_difficulty']}}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-6">
                                            <p><i class="far fa-clock pe-1"></i>duration</p>
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
<div class="container">
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
                        <p class="card-text-1">Cohort starts - {{$singleCourseDetail['start_date']}}</p>
                        <p class="card-text-1">{{$singleCourseDetail['batchname']}}</p>
                        <p class="card-text">
                            {{$singleCourseDetail['start_time']}} {{$singleCourseDetail['region']}} - {{$singleCourseDetail['end_time']}}
                            {{$singleCourseDetail['region']}}
                        </p>
                    
                    </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row mt-4">
        <div class="form-group buttons d-flex justify-content-end">
            @csrf
            <button type="submit" id="registerNowButton" class="btn">Register Now</button>
            <input type="hidden" id="course_id" value="{{$courseDetails['course_id']}}">
        </div>
    </div>
</div>
</section>

<script>
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
            window.location.href ="/enrolled-course";
            }
            
        });
});

</script>
@endsection('content')