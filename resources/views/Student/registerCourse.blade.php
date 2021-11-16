@extends('Layouts.enrollCourse')
@section('content')



<header class="d-flex align-items-center mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-1 mb-3 mt-4">
                    <div class="row g-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <img src="/courselist/Illustration/Mask Group 2.jpg" class="img-fluid col-md-12 col-sm-12 col-12 card-image h-100" alt="coursepicture">
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card-body">
                                <h5 class="card-title pb-3">
                                    @foreach($singleCourseDetails as $singleCourseDetail)
                                        {{$singleCourseDetail['course_title']}}
                                    @endforeach
                                </h5>
                                <p class="card-text">By learning both of these apps, 
                                    you will gain valuable productivity skills & become more efficient at creating documents, spreadsheets, 
                                    and presentations.</p>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-3">
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i>
                                            <i class="fas fa-star rateCourse"></i><small>(60 ratings) 100 participants</small>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                                        <p><i class="fas fa-tag fa-flip-horizontal"></i>
                                            @foreach($singleCourseDetails as $singleCourseDetail)
                                                {{$singleCourseDetail['course_category']}}
                                            @endforeach
                                        </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                                        <p><i class="far fa-user"></i>
                                                @foreach($singleCourseDetails as $singleCourseDetail)
                                                    {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                                                @endforeach
                                                </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                                        <p><i class="far fa-user"></i>
                                                @foreach($singleCourseDetails as $singleCourseDetail)
                                                        {{$singleCourseDetail['course_difficulty']}}
                                                @endforeach
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                                            <p><i class="far fa-clock"></i>duration</p>
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
            <h1 class="border-bottom pb-3">Choose Your Chort</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-4">
            <div class="card-2 text-center" style="width: auto;">
                <div class="card-body">
                    <i class="far fa-calendar-alt pb-3"></i>
                    <p class="card-text-1">Cohort starts - Nov 15</p>
                    <p class="card-text-1">Mon - Wed - Fri</p>
                    <p class="card-text">9 AM IST - 10 AM IST</p>
                    
                </div>
            </div>
        </div>

     
        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-4">
            <div class="card-2 text-center" style="width: auto;">
                <div class="card-body">
                    <i class="far fa-calendar-alt pb-3"></i>
                    <p class="card-text-1">Cohort starts - Nov 15</p>
                    <p class="card-text-1">Mon - Wed - Fri</p>
                    <p class="card-text">9 AM IST - 10 AM IST</p>
                    
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-4">
            <div class="card-2 text-center" style="width: auto;">
                <div class="card-body">
                    <i class="far fa-calendar-alt pb-3"></i>
                    <p class="card-text-1">Cohort starts - Nov 15</p>
                    <p class="card-text-1">Mon - Wed - Fri</p>
                    <p class="card-text">9 AM IST - 10 AM IST</p>
                    
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-4">
        <div class="form-group buttons d-flex justify-content-end">
            <button type="submit" class="btn update-btn">Register Now</button>
        </div>
    </div>
        

        
        

        

    </div>
</div>
</section>


@endsection('content')