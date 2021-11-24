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
              <li class="pb-2"><i class="fas fa-arrow-right"></i>Praesentium voluptatum deleniti atque.</li>
              <li class="pb-2"><i class="fas fa-arrow-right"></i>Corrupti quos dolores et quas molestias.</li>
              <li class="pb-2"><i class="fas fa-arrow-right"></i>Excepturi sint occaecati cupiditate.</li>
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
        <div class="filter m-4 pt-2 p-4">
          <h6>Filter</h6>
          <div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item filter-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
      <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        <h6>Topics</h6>
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
      <div class="accordion-body">
      <div class="form-check">
        <input class="form-check-input category_filter" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Default checkbox
        </label>
      </div>
      </div>
    </div>
  </div>
  <div class="accordion-item filter-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
      <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        Learning Levels
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingTwo">
      <div class="accordion-body">
      <div class="form-check">
        <input class="form-check-input category_filter" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Default checkbox
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input category_filter" type="checkbox" value="0" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          All levels
        </label>
      </div>
      </div>
    </div>
  </div>
  <div class="accordion-item filter-item">
    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
      <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
        Ratings
      </button>
    </h2>
    <div id="panelsStayOpen-collapseThree" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingThree">
      <div class="accordion-body">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            Default radio
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="far fa-star filter-no-star"></i>
            Default radio
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="far fa-star filter-no-star"></i>
            <i class="far fa-star filter-no-star"></i>
            Default radio
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            <i class="fas fa-star filter-star"></i>
            <i class="fas fa-star filter-star"></i>
            <i class="far fa-star filter-no-star"></i>
            <i class="far fa-star filter-no-star"></i>
            <i class="far fa-star filter-no-star"></i>
            Default radio
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
          <label class="form-check-label" for="flexRadioDefault1">
            <i class="fas fa-star filter-star"></i>
            <i class="far fa-star filter-no-star"></i>
            <i class="far fa-star filter-no-star"></i>
            <i class="far fa-star filter-no-star"></i>
            <i class="far fa-star filter-no-star"></i>
            Default radio
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
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
          @foreach($courseDatas as $courseData)
            <div class="col-lg-6">
              <div class="card mb-4">
                <img src="{{asset('/storage/images/'.$courseData['course_image'])}}" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title text-center">
                      {{$courseData['course_title']}}
                    </h5>
                    <p class="card-text">
                      {{\Illuminate\Support\Str::limit($courseData['description'],
                         $limit = 150, $end = '....')}} 
                         <a href="{{ route('student.course.show',$courseData['id']) }}" class="">Read More</a>
                    </p>
                    <div class="row">
                      <div class="col-lg-6 col-sm-6 col-6">
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>
                        <i class="fas fa-star rateCourse"></i>(60)
                      </div>
                        
                      <div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">
                        <i class="fas fa-tag fa-flip-horizontal ps-2"></i>{{$courseData['course_category']}}
                      </div>
                    </div>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4 col-4 item-1"><i class="far fa-clock pe-1"></i>1h 50m</div>
                        <div class="col-lg-4 col-4 item-2 text-center"><i class="far fa-user pe-1"></i>
                        {{$courseData['instructor_firstname']}} {{$courseData['instructor_lastname']}}
                        </div>
                        <div class="col-lg-4 col-4 item-3">{{$courseData['course_difficulty']}}</div>
                      </div>
                    </li>
                  </ul>
                  <div class="card-body">
                    <div class="row">
                      <div class="btn-group border-top" role="group" aria-label="Basic example">
                        <a href="" class="card-link btn border-end">Register now</a>
                        <a href="{{ route('student.course.show', $courseData['id'])}}" class="card-link btn">Go to details<i class="fas fa-arrow-right ps-2"></i></a>
                    </div>
                  </div>
              </div>
            </div>
            </div>
           @endforeach
           <div class="d-flex justify-content-center">
              {{ $courseDatas->links() }}
            </div>
           </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection('content')


