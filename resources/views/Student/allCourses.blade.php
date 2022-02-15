@extends('Layouts.app')
@section('content')

@if(!$searchTerm)
<header class="think-banner-allcourses ty-mac-header-bg d-flex align-items-center mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-sm-12 d-flex align-items-center p-3">
        <div class="text-content-wrapper d-flex d-lg-block flex-column align-items-center w-100 text-center text-lg-start">
          <p>Lorem ipsum dolor sit amet</p>
          <h1 class="mb-3">Dignissimos Ducimus</h1>
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
@endif
<section class="section-2 pt-5 {{ (!!$searchTerm) ? 'mt-5' : '' }}">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="think-filters-sidebar filter m-4 pt-2 p-4">
          <h6>Filter</h6>
          <div class="accordion" id="accordionPanelsStayOpenExample">
            @foreach($filters as $filter)
            @if($filter->filter_name == Config::get('common.FILTER_NAME_CATEGORY') && $filter->is_enabled == true)
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
                    <input class="form-check-input category_filter filter_option" id="category{{$category->id}}" filtertype="category" type="checkbox" value="{{$category->id}}">
                    <label class="form-check-label" for="category{{$category->id}}">
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
            @if($filter->filter_name == Config::get('common.FILTER_NAME_DIFFICULTY') && $filter->is_enabled == true)
            <div class="accordion-item filter-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                  <h6>Learning Levels</h6>
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                  <div class="form-check">
                    <input class="form-check-input difficulty_filter filter_option" filtertype="difficulty" type="checkbox" value="Advanced" id="Advanced">
                    <label class="form-check-label" for="Advanced">
                      Advanced
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input difficulty_filter filter_option" filtertype="difficulty" type="checkbox" value="Intermediate" id="Intermediate">
                    <label class="form-check-label" for="Intermediate">
                      Intermediate
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input difficulty_filter filter_option" filtertype="difficulty" type="checkbox" value="Beginner" id="Beginner">
                    <label class="form-check-label" for="Beginner">
                      Beginner
                    </label>
                  </div>

                </div>
              </div>
            </div>
            @endif
            @endforeach
            @foreach($filters as $filter)
            @if($filter->filter_name == Config::get('common.FILTER_NAME_RATINGS') && $filter->is_enabled == true)
            <div class="accordion-item filter-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                  <h6>Ratings</h6>
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
            @if($filter->filter_name == Config::get('common.FILTER_NAME_DURATION') && $filter->is_enabled == true)
            <div class="accordion-item filter-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                  <h6>Course Duration</h6>
                </button>
              </h2>
              <div id="panelsStayOpen-collapseFour" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingFour">
                <div class="accordion-body">
                  <div class="form-check">
                    <input class="form-check-input duration_filter filter_option" filtertype="duration" type="checkbox" value="less_than_1">
                    <label class="form-check-label" for="flexCheckDefault">
                      < 1 Hour </label>
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
            @if($filter->filter_name == Config::get('common.FILTER_NAME_INSTRUCTOR') && $filter->is_enabled == true)
            <div class="accordion-item filter-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                <button class="accordion-button filter-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                  <h6>Instructors</h6>
                </button>
              </h2>
              <div id="panelsStayOpen-collapseFive" class="accordion-collapse" aria-labelledby="panelsStayOpen-headingFive">
                <div class="accordion-body">
                  @foreach($instructors as $instructor)
                  <div class="form-check">
                    <input class="form-check-input instructor_filter filter_option" filtertype="instructor" type="checkbox" value="{{$instructor->id}}">
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
          <div class="col-lg-7 col-sm-6 col-6 d-flex justify-content-start p-4">
            @if(!!$searchTerm)
            <h3>Search results for "{{ $searchTerm }}"</h3>
            @else
            <h3>Courses For You</h3>
            @endif
          </div>
          <div class="col-lg-5 col-sm-6 col-6 d-flex justify-content-end p-4">
            <select name="" id="all_course_drop" class="rounded">
              <option value="" disabled selected>Sort</option>
              <option value="most_popular">Most Popular</option>
              <option value="most_reviewed">Most Reviewed</option>
            </select>
          </div>
        </div>

        <div class="row" id="course_view_section">
          @forelse($courseDatas as $course)
          <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
            <x-courseboxsmall :course="$course" />
          </div>
          @empty
          <x-nodatafound message="No courses to be shown!" notype="course" />
          @endforelse
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</section>


@endsection('content')
@push('child-scripts')
<script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
<script>
  window.onload = function(event) {
    let filterOption = document.getElementsByClassName('filter_option');
    for (var index = 0; index < filterOption.length; index++) {
      filterOption[index].addEventListener('change', function(event) {
        let categoryFilters = [];
        let levelFilters = [];
        let ratingFilter = [];
        let durationFilter = [];
        let instructorFilter = [];
        filterType = this.getAttribute('filtertype');
        for (var i = 0; i < filterOption.length; i++) {
          if (filterOption[i].checked) {
            if (filterOption[i].getAttribute('filterType') == "category") {
              categoryFilters.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
            } else if (filterOption[i].getAttribute('filterType') == "difficulty") {
              levelFilters.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
            } else if (filterOption[i].getAttribute('filterType') == "rating") {
              ratingFilter.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
            } else if (filterOption[i].getAttribute('filterType') == "duration") {
              durationFilter.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
            } else if (filterOption[i].getAttribute('filterType') == "instructor") {
              instructorFilter.push(filterOption[i].getAttribute('filterType') + '=' + filterOption[i].getAttribute('value'));
            }
          }
        }
        let path = "{{ route('filter-course')}}?categories=" + categoryFilters + "&levels=" + levelFilters + "&ratings=" + ratingFilter + "&duration=" + durationFilter + "&instructors=" + instructorFilter;
        fetch(path, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
          },
          body: JSON.stringify({})
        }).then((response) => response.json()).then((data) => {
          console.log(data);
          document.getElementById('course_view_section').innerHTML = data.html;
        });
      });
    }

    document.getElementById('all_course_drop').addEventListener('change', function(e) {
      let filterValue = this.value;
      let path = "{{ route('course-drop-down')}}?filterValue=" + filterValue;
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
    })
  }
</script>
@endpush