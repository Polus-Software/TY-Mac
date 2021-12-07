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
          @foreach($filters as $filter)
          @if($filter->filter_name == "Category" && $filter->is_enabled == true)
          <div class="accordion-item filter-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
              <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                <h6>{{$filter->filter_name}}</h6>
              </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
              <div class="accordion-body">
              @csrf
              @foreach($allCourseCategory as $category)
              <div class="form-check">
                <input class="form-check-input category_filter filter_option" filtertype="category" type="checkbox" value="{{$category->id}}">
                <label class="form-check-label" for="flexCheckDefault">
                  {{$category->category_name}}
                </label>
              </div>
              @endforeach
              </div>
            </div>
          </div>
          @endif
          @endforeach

          @foreach($filters as $filter)
          @if($filter->filter_name == "Difficulty" && $filter->is_enabled == true)        
          <div class="accordion-item filter-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
              <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                Learning Levels
              </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingTwo">
              <div class="accordion-body">
              <div class="form-check">
                <input class="form-check-input difficulty_filter filter_option" filtertype="difficulty" type="checkbox" value="Advanced" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Advanced
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input difficulty_filter filter_option" filtertype="difficulty" type="checkbox" value="Intermediate" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Intermediate
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input difficulty_filter filter_option" filtertype="difficulty" type="checkbox" value="Beginner" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Beginner
                </label>
              </div>
              
              </div>
            </div>
          </div>
          @endif
          @endforeach
          @foreach($filters as $filter)
          @if($filter->filter_name == "Ratings" && $filter->is_enabled == true)
            <div class="accordion-item filter-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                  Ratings
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">
                  <div class="form-check">
                    <input class="form-check-input rating_filter filter_option" filtertype="rating" type="radio" name="flexRadioDefault" value="5">
                    <label class="form-check-label" for="flexRadioDefault1">
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      (5 stars)
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input rating_filter filter_option" filtertype="rating" type="radio" name="flexRadioDefault" value="4">
                    <label class="form-check-label" for="flexRadioDefault1">
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      (4 stars & up)
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input rating_filter filter_option" filtertype="rating" type="radio" name="flexRadioDefault" value="3">
                    <label class="form-check-label" for="flexRadioDefault1">
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      (3 stars & up)
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input rating_filter filter_option" filtertype="rating" type="radio" name="flexRadioDefault" value="2">
                    <label class="form-check-label" for="flexRadioDefault1">
                      <i class="fas fa-star filter-star"></i>
                      <i class="fas fa-star filter-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      (2 stars & up)
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input rating_filter filter_option" filtertype="rating" type="radio" name="flexRadioDefault" value="1">
                    <label class="form-check-label" for="flexRadioDefault1">
                      <i class="fas fa-star filter-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      <i class="far fa-star filter-no-star"></i>
                      (1 star & up)
                    </label>
                  </div>
                </div>
              </div>
            </div>
          @endif
          @endforeach

          @foreach($filters as $filter)
          @if($filter->filter_name == "Duration" && $filter->is_enabled == true)        
          <div class="accordion-item filter-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingFour">
              <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                Course Duration
              </button>
            </h2>
            <div id="panelsStayOpen-collapseFour" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingFour">
              <div class="accordion-body">
              <div class="form-check">
                <input class="form-check-input duration_filter filter_option" filtertype="duration" type="checkbox" value="less_than_1">
                <label class="form-check-label" for="flexCheckDefault">
                  < 1 Hour
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input duration_filter filter_option" filtertype="duration" type="checkbox" value="less_than_2">
                <label class="form-check-label" for="flexCheckDefault">
                  1 to 2.5 Hours
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input duration_filter filter_option" filtertype="duration" type="checkbox" value="less_than_5">
                <label class="form-check-label" for="flexCheckDefault">
                  2.5 to 5 Hours
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input duration_filter filter_option" filtertype="duration" type="checkbox" value="greater_than_5">
                <label class="form-check-label" for="flexCheckDefault">
                  > 5 Hours
                </label>
              </div>
              </div>
            </div>
          </div>
          @endif
          @endforeach

          @foreach($filters as $filter)
          @if($filter->filter_name == "Instructor" && $filter->is_enabled == true)        
          <div class="accordion-item filter-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingFive">
              <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                Instructors
              </button>
            </h2>
            <div id="panelsStayOpen-collapseFive" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingFive">
              <div class="accordion-body">
              @foreach($instructors as $instructor)
              <div class="form-check">
                <input class="form-check-input instructor_filter" type="checkbox" value="{{$instructor->id}}">
                <label class="form-check-label" for="flexCheckDefault">
                  {{$instructor->firstname}} {{$instructor->lastname}}
                </label>
              </div>
              @endforeach
              </div>
            </div>
          </div>
          @endif
          @endforeach
</div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="row border-bottom mb-4">
          <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-start p-4">
            <h3>Courses For You</h3>
          </div>
          <div class="col-lg-6 col-sm-6 col-6 d-flex justify-content-end p-4">
            <select name="" id="" class="rounded">
              <option value="most-popular">Most Popular</option>
              <option value="">Most Popular</option>
              <option value="">Most Popular</option>
              <option value="">Most Popular</option>
            </select>
          </div>
        </div>

        <div class="row" id="course_view_section">
          <!-- <div id="course_view_section"> -->
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
                        @for($i = 1; $i <= 5; $i++)
                           @if($i <= $courseData['rating'])
                            <i class="fas fa-star rateCourse"></i>
                           @else
                            <i class="far fa-star rateCourse"></i>
                           @endif
                        @endfor
                        (60)
                      </div>
                        
                      <div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">
                        <i class="fas fa-tag fa-flip-horizontal ps-2"></i>{{$courseData['course_category']}}
                      </div>
                    </div>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <div class="row">
                        <div class="col-lg-3 col-sm-4 col-4 item-1"><i class="far fa-clock pe-1"></i>{{$courseData['duration']}}</div>
                        <div class="col-lg-5 col-4 item-2 text-center"><i class="far fa-user pe-1"></i>
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
           <!-- </div> -->
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

<script>

window.onload = function(event) {

  

  let filterOption = document.getElementsByClassName('filter_option');
  for(var index = 0; index < filterOption.length; index++) {
    filterOption[index].addEventListener('change', function(event) {
      let categoryFilters = [];
      let levelFilters = [];
      let ratingFilter = [];
      filterType = this.getAttribute('filtertype');
      for(var i = 0; i < filterOption.length; i++) {
        if(filterOption[i].checked) {
          if(filterOption[i].getAttribute('filterType') == "category") {
            categoryFilters.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
          } else if (filterOption[i].getAttribute('filterType') == "difficulty") {
            levelFilters.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
          } else if (filterOption[i].getAttribute('filterType') == "rating") {
            ratingFilter.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
          }
        }
      }
      let path = "{{ route('filter-course')}}?categories=" + categoryFilters + "&levels=" + levelFilters + "&ratings=" + ratingFilter;
      fetch(path, {
          method: 'POST',
          headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              "X-CSRF-Token": document.querySelector('input[name=_token]').value
          },
          body: JSON.stringify({})
      }).then((response) => response.json()).then((data) => {
        document.getElementById('course_view_section').innerHTML = data.html;
      });
   });
  }
}




</script>


