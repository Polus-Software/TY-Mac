@extends('Layouts.courses')
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

 
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TY-Mac</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <form class="mb-2 mb-lg-0 mt-lg-0 d-flex me-auto mt-3 col-lg-6">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="">
        <button class="btn btn-outline-success" type="submit" id="search-btn">Search</button>
      </form>

      <ul class="navbar-nav">
      @if (Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="{{ route('edituser') }}">Welcome, {{Auth::user()->firstname}}</a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('student.courses.get') }}">All Courses</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#">Apply to be an instructor?</a>
        </li> -->
        @if (Auth::check())
        @if(Auth::user()->role_id == 3)

        <li class="nav-item">
          <a class="nav-link" href="{{ route('assigned-courses') }}">Assigned Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ route('my-courses') }}">My courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @endif
        @else
        <li class="nav-item">
        <a class="nav-link" href="#signup" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
        </li>
        @endif
      </ul>
      
    </div>
  </div>
</nav>
<!-- login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
   <div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-body">
     <div class="container-overlay">
      <div class="mx-auto">
        <div class="wrapper row flex-column my-5" >  
            <div class="form-group mx-sm-5 mx-0 custom-form-header mb-4">Log in to account</div>
                <form id="loginForm" class="form" method="POST" action="{{route('user.login.post')}}">
                    @csrf
                    <div class="form-group mx-sm-5 mx-0">
                        <label for="email" class="email-label">Email</label>
                        <input type="email"  name="email"class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com"
                        value="{{old('email')}}">
                        <small>Error message</small>
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif        
                    </div>
                    <div class="form-group mx-sm-5 mx-0">
                        <label for="inputPassword" class="password-label">Password</label>
                        <input type="password"  name="password" class="form-control" id="inputPassword" placeholder="Password"  value="{{old('password')}}">
                        <span><i class="fas fa-eye-slash"  id="togglePassword" onClick="viewPassword()"></i></span>
                        <small>Error message</small>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group mx-sm-5 mx-0">
                        <label class="form-check-label rememberme">
                        <input  class="form-check-input"  name="remember_me" type="checkbox"> &nbsp;Remember me</label>
                    </div>

                    <div class="d-grid form-group  mx-sm-5 mx-0">
                        <button type="submit" class="btn btn-block loginBtn"><span class="button">Login</span></button>
                    </div>

                    <div class="text-center forgotpass">
                        <span class="forgotpwd"><a href="{{ route('forget.password.get')}}"> Forgot password? </a></span>
                        
                    </div>

                    <div class="text-center bottom-text">
                        <span><p>Don't have an account? </span>
                        <span class="login"><a href="{{ route('signup') }}">&nbsp;Sign up</a></p></span>
                    </div>            
            
                </form>
            </div> 
        </div>      
     </div>          

    </div>
    
   </div>
</div>
</div>
</div>
<!-- login modal ends -->
 <!-- signup modal -->
 <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-container mx-auto p-3 rounded">
      <div class="modal-content border-0">
        <div class="modal-header border-0">
          <h5 class="modal-title mx-sm-5 mx-0 custom-form-header" id="signupModalLabel">Create an account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
            <form id="signupForm" class="form" method="POST" action="{{ route('user.create') }}">
              @csrf
              <input type="hidden" name="_method" value="POST">

              <div class="form-group mx-sm-5 mx-0">
                <label for="firstName" class="firstname-label">First Name</label>
                <input type="text" name="firstname" class="form-control" id="firstName" placeholder="Eg: Denis" value="{{old('firstname')}}">
                <small>Error message</small>

                @if ($errors->has('firstname'))
                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                @endif
                </span>
              </div>

              <div class="form-group mx-sm-5 mx-0">
                <label for="lastName" class="lastname-label">Last Name</label>
                <input type="text" name="lastname" class="form-control" id="lastName" placeholder="Eg: Cheryshev" value="{{old('lastname')}}">
                <small>Error message</small>

                @if ($errors->has('lastname'))
                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                @endif

              </div>

              <div class="form-group mx-sm-5 mx-0">
                <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Eg: xyz@domainname.com" value="{{old('email')}}">
                <small>Error message</small>

                @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>

              <div class="form-group mx-sm-5 mx-0">
                <label for="inputPassword" class="password-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <span><i class="fas fa-eye-slash" id="togglePass" onClick="viewPassword()"></i></span>
                <small>Error message</small>


                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>

              <div class="form-group mx-sm-5 mx-0">
                <label for="confirmPassword" class="password-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Retype password">
                <span><i class="fas fa-eye-slash" id="confirm_togglePassword" onClick="showPassword()"></i></span>
                <small>Error message</small>

                @if ($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
              </div>

              <div class="form-group mx-sm-5 mx-0">
                <label class="form-check-label checkbox-text">
                  <input class="form-check-input" name="privacy_policy" type="checkbox"> By creationg an account , you agree to the
                  <a href="#">Terms of Service</a> and Conditions, and Privacy Policy</label>
                @if ($errors->has('privacy_policy'))
                <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                @endif
              </div>

              <div class="d-grid form-group mx-sm-5 mx-0">
                <button type="submit" class="btn btn-secondary loginBtn"><span class="button">Create</span></button>
              </div>

              <div class="text-center bottom-text">
                <span>
                  <p>Already have an account?
                </span>
                <span class="login"><a href="{{ route('login') }}">&nbsp;Login</a></p></span>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer border-0"></div>
      </div>
    </div>
  </div>
<!-- signup modal ends -->
<header class="ty-mac-header-bg d-flex align-items-center">
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
            </select>
          </div>
        </div>

        <div class="row" id="course_view_section">
          <!-- <div id="course_view_section"> -->
          @foreach($courseDatas as $courseData)
            <div class="col-lg-6">
              <div class="card mb-4">
                <img src="{{asset('/storage/courseThumbnailImages/'.$courseData['course_thumbnail_image'])}}" class="card-img-top" alt="course-image">
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
                        
                      <div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end p-0 pe-2">
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
                        <div class="col-lg-4 col-sm-4 col-4 item-3 d-flex justify-content-end">{{$courseData['course_difficulty']}}</div>
                      </div>
                    </li>
                  </ul>
                  <div class="card-body">
                    <div class="row">
                      <div class="btn-group border-top" role="group" aria-label="Basic example">
                     @if(Auth::guest())
                        <a class="card-link btn border-end" id="registerNowButton"  data-bs-toggle="modal"
                         data-bs-target="#loginModal">Register now</a>
                      @else
                        <a href="{{ route('student.course.register', ['id'=>$courseData['id']])}}" class="card-link btn border-end">Register now</a>
                      @endif
                     
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

<script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
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
  
document.querySelector('#loginForm').addEventListener('submit', function(e) {
        if(loginemail.value === '') {
            e.preventDefault();
            showError(loginemail,'Email is required');
        }else {
            removeError(loginemail);
        }
        if(loginpassword.value === '') {
            e.preventDefault();
            showError(loginpassword,'Password is required');
        } else {
            removeError(loginpassword);
        }
    });

const loginform = document.getElementById('loginForm');
const loginemail = document.getElementById('inputEmail');
const loginpassword = document.getElementById('inputPassword');
   

function showError(input,message){
  input.style.borderColor = 'red';
  const formControl=input.parentElement;
  const small=formControl.querySelector('small');
  small.innerText=message;
  small.style.visibility = 'visible';
}

function removeError(input){
input.style.borderColor = '#ced4da';
const formControl=input.parentElement;
const small=formControl.querySelector('small');
small.style.visibility = 'hidden';
}
}

</script>


