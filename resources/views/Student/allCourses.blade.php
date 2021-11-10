@extends('Layouts.courses')
@section('content')
<header class="ty-mac-header-bg d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-sm-12 d-flex align-items-center p-3">
          <div class="text-content-wrapper d-flex d-lg-block flex-column align-items-center w-100 text-center text-lg-start">
            <p>Lorem ipsum dolor sit amet</p>
            <h1>Dignissimos Ducimus</h1>
            <ul class="p-0 m-0">
              <li class="pb-2"><i class="fas fa-arrow-right">Praesentium voluptatum deleniti atque.</i></li>
              <li class="pb-2"><i class="fas fa-arrow-right">Corrupti quos dolores et quas molestias.</i></li>
              <li class="pb-2"><i class="fas fa-arrow-right">Excepturi sint occaecati cupiditate.</i></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-7 col-12">
          <img src="courselist/Illustration/Illustration.svg" class="img-fluid" alt="courseimage">
        </div>
      </div>
    </div>
</header>
<section class="section-2 pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="filter m-4">
          <h1>filter</h1>
        </div>
      </div>

      <div class="col-md-8">
        <div class="row border-bottom mb-4">
          <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-start p-4">
            <h3>Courses For You</h3>
          </div>
          <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-end p-4">
            <select name="" id="" class="rounded" >
              <option value="most-popular">Most Popular</option>
              <option value="">Most Popular</option>
              <option value="">Most Popular</option>
              <option value="">Most Popular</option>
            </select>
          </div>
        </div>

        <div class="row">
          @foreach($courseDetails as $courseDetail)
            <div class="col-lg-6">
              <div class="card mb-4">
                <img src="courselist/Illustration/Mask Group 2.jpg" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title text-center">
                      {{$courseDetail['course_title']}}
                    </h5>
                    <p class="card-text">
                      {{\Illuminate\Support\Str::limit($courseDetail['description'],
                         $limit = 150, $end = '....')}} 
                         <a href="{{ route('student.course.show') }}" class="">Read More</a>
                    </p>
                    <div class="row p-1">
                      <div class="col-lg-6 col-sm-6 col-6">
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>(60)
                      </div>
                        
                      <div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">
                        <i class="fas fa-tag fa-flip-horizontal"></i>{{$courseDetail['course_category']}}
                      </div>
                    </div>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-lg-4 col-4 item-1"><i class="far fa-clock"></i>duration</div>
                        <div class="col-lg-4 col-4 item-2"><i class="far fa-user"></i>
                        {{$courseDetail['instructorfirstname']}} {{$courseDetail['instructorlastname']}}
                        </div>
                        <div class="col-lg-4 col-4 item-3">{{$courseDetail['course_difficulty']}}</div>
                      </div>
                    </li>
                  </ul>
                  <div class="card-body">
                    <div class="row">
                      <div class="btn-group border-top" role="group" aria-label="Basic example">
                      <button type="button card-link" class="btn border-end">Register Now</button>
                      <button type="button card-link" class="btn">
                        <a href="{{ route('student.course.show') }}">Go to details<i class="fas fa-arrow-right"></i></a>
                      </button>
                    </div>
                  </div>
              </div>
            </div>
            </div>
           @endforeach
           </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="d-flex justify-content-center">
         
</div>
@endsection('content')