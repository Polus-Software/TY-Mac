@extends('Layouts.showCourse')
@section('content')


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
<!-- end login modal -->


    <header class="ty-mac-header-bg d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 order-2 order-lg-1 p-3 ">
                  
                <div class="text-content-wrapper w-100 text-lg-start">
                    <p>@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['course_title']}}
                    @endforeach
                    </p>
                </div>
                <div class="row row-1">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                        <p class="border-end"><i class="far fa-clock"></i>Duration</p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                        <p class="border-end">@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['course_difficulty']}}
                    @endforeach</p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                        <p>@foreach($singleCourseDetails as $singleCourseDetail)
                    {{$singleCourseDetail['course_category']}}
                    @endforeach</p>
                    </div>
                </div>
                <div class="row row-2">
                    <div class="col-lg-12">
                        <p class="para-1">What You'll Learn</p>
                        <p class="para-2"><i class="fas fa-check-circle"></i> &nbsp;Lorem ipsum dolor sit amet, 
                            consectetur adipiscing elit, sed do eiusmod.</p>
                        <p class="para-2"><i class="fas fa-check-circle"></i> &nbsp;Lorem ipsum dolor sit amet,
                             consectetur adipiscing elit, sed do eiusmod tempor.</p>
                    </div>
                </div>
                <div class="row row-3 pt-2">
                    <div class="col-lg-6">
                        <p class="para-3">Instructed by <strong class="text-capitalize">
                        @foreach($singleCourseDetails as $singleCourseDetail)
                          {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                        @endforeach
                        </strong></p>
                    </div>
                    <div class="col-lg-6">
                        <p>Upcoming Cohort:<strong> 11/10/2021</strong></p>
                    </div>
                   
                </div>
                <div class="row pt-2">
                    <div class="col-lg-4">
                        <a class="btn enroll-button" type="button"  id="enrollButton">
                            Enroll now
                        </a>
                        <input type="hidden" id="course_id" value="{{$singleCourseDetail['id']}}">
                    </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 order-1 order-lg-2">
                  <img src="/courselist/fundamentals of google docs.jpg" alt="" 
                  class="img-fluid course-picture" style="height: auto;">
              </div>
          </div>
      </div>
    </header>

    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-1">
                        <div class="card-body p-4">
                          <h5 class="card-title">Course description</h5>
                          @foreach($singleCourseDetails as $singleCourseDetail)
                            <p class="card-text-1"> {{$singleCourseDetail['description']}}</p>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-3">
     <div class="container">
         <div class="row">
             <div class="col-lg-8">
                <div class="card card-2 mb-3">
                    <div class="card-body">
                        <h5 class="card-title border-bottom p-2">Course Content</h5>
                        <h6 class="card-subtitle p-2">Session 1 - Intro to G Suite & Google Drive</h6>
                        <ul class="list-group list-group-flush border-bottom pb-3">
                            <li class="list-group-item">
                                <ul>
                                    <li>How to use Google Suite</li>
                                    <li>How to use Google Drive</li>
                                    <li>Creating a folder in Google Drive</li>
                                    <li>Sharing a folder in Google Drive</li>
                                </ul>
                            </li>
                        </ul>   
                        <h6 class="card-subtitle p-3">Session 1 - Intro to G Suite & Google Drive</h6>
                        <ul class="list-group list-group-flush border-bottom pb-3">
                            <li class="list-group-item">
                                <ul>
                                    <li>How to use Google Suite</li>
                                    <li>How to use Google Drive</li>
                                    <li>Creating a folder in Google Drive</li>
                                    <li>Sharing a folder in Google Drive</li>
                                </ul>
                            </li>
                        </ul>   
                        <h6 class="card-subtitle p-3">Session 1 - Intro to G Suite & Google Drive</h6>
                        <ul class="list-group list-group-flush border-bottom pb-3">
                            <li class="list-group-item">
                                <ul>
                                    <li>How to use Google Suite</li>
                                    <li>How to use Google Drive</li>
                                    <li>Creating a folder in Google Drive</li>
                                    <li>Sharing a folder in Google Drive</li>
                                </ul>
                            </li>
                        </ul>   
                        <h6 class="card-subtitle p-3">Session 1 - Intro to G Suite & Google Drive</h6>
                        <ul class="list-group list-group-flush pb-3">
                            <li class="list-group-item">
                                <ul>
                                    <li>How to use Google Suite</li>
                                    <li>How to use Google Drive</li>
                                    <li>Creating a folder in Google Drive</li>
                                    <li>Sharing a folder in Google Drive</li>
                                </ul>
                            </li>
                        </ul>   
                        

                        
                    </div>
                </div>
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body p-3">
                      <h5 class="card-title p-2">Who this course is for</h5>
                      <p class="card-text-1 p-2">At vero eos et accusamus et iusto odio dignissimos ducimus qui 
                        blanditiis praesentium voluptatum deleniti atque corrupti quos 
                        dolores et quas molestias excepturi sint occaecati cupiditate non provident, 
                        similique sunt in culpa qui officia deserunt mollitia animi, 
                        id est laborum.</p>

                        <p class="card-text-1"><i class="far fa-check-circle"></i> &nbsp;
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                            sed do eiusmod.
                        </p>
                        <p class="card-text-1"><i class="far fa-check-circle"></i> &nbsp;
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                            sed do eiusmod.
                        </p>
                        <p class="card-text-1"><i class="far fa-check-circle"></i> &nbsp;
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                            sed do eiusmod.
                        </p>
                    
                    </div>
                </div>
        
            </div>
                
             </div>
             <div class="col-lg-4">
                <div class="card card-3 mb-5">
                    <div class="row g-0 border-bottom" style=" background:#F8F7FC; border-radius:10px 10px 0px 0px;">
                         <div class="col-lg-4 col-sm-4 col-4">
                         @foreach($singleCourseDetails as $singleCourseDetail)
                           <img src="{{asset('/storage/images/'.$singleCourseDetail['profile_photo'])}}" class="img-fluid rounded-circle m-2 p-2 d-flex align-items-center" 
                           alt="..." style="width:94px; height:94px;">
                           @endforeach
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8">
                        <div class="card-body">
                          <h5 class="card-title pt-2">
                            @foreach($singleCourseDetails as $singleCourseDetail)
                              {{$singleCourseDetail['instructor_firstname']}} {{$singleCourseDetail['instructor_lastname']}}
                            @endforeach</h5>
                          <p class="card-text-1">Prof. at TY-Mac</p>
                        </div>
                        </div>
                    </div>
                      <div class="row">
                          <div class="col-md-12">
                              <p class="card-text-1 p-3" style="line-height: 32px;;">Lorem ipsum dolor sit amet, consectetsur lete adipiscing elit, 
                                sed do eiusmod tempor sed incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                commodo consequat sunt explicabo</p>
                          </div>
                          <div class="d-flex justify-content-center">
                              <p><i class="fab fa-twitter"></i>
                                <i class="fab fa-linkedin-in"></i>
                                <i class="fab fa-youtube"></i></p>
                          </div>
                      </div>
                    
                  </div>
                  <div class="card card-4 mb-3 mt-3" style="background: #F8F7FC;">
                    <div class="card-body">
                        <h5 class="card-title p-3">Upcoming Live Cohorts</h5>
                        @foreach($singleCourseDetails as $singleCourseDetail)
                            <div class="row g-0 border-bottom">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <img src="/courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block p-2" alt="...">
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{$singleCourseDetail['instructor_firstname']}} 
                                            {{$singleCourseDetail['instructor_lastname']}}
                                        </h5>
                                        <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    <!-- <div class="row g-0 border-bottom mt-3">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <img src="courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block p-2" alt="...">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                <div class="card-body">
                                    <h5 class="card-title">Carole Franklin</h5>
                                    <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                                </div>
                            </div>
                    </div>

                    <div class="row g-0 border-bottom mt-3">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <img src="courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block p-2" alt="...">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="card-body">
                                <h5 class="card-title">Carole Franklin</h5>
                                <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                            </div>
                        </div>
                </div>
                <div class="row g-0 border-bottom mt-3">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                        <img src="courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block p-2" alt="...">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                        <div class="card-body">
                            <h5 class="card-title">Carole Franklin</h5>
                            <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                        </div>
                    </div>
            </div>
            <div class="row g-0 border-bottom mt-3 mb-3">
                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                    <img src="courselist/Mask Group 6.jpg" class="img-fluid mx-auto d-block p-2" alt="...">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                    <div class="card-body">
                        <h5 class="card-title">Carole Franklin</h5>
                        <p class="card-text course-time">Mon, 9 AM IST - 10 AM IST - 10/11/2021</p>
                    </div>
                </div>
                </div> -->
            </div>
            </div>
         </div>
     </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-5 mb-2">
                            <div class="card-body">
                                <h5 class="card-title p-3">Student Reviews</h5>
                              <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                    <img src="/courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                                    <div class="card-body">
                                        <h5 class="card-title text-left">James Parker</h5>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                              <i class="fas fa-star"></i>
                                              <i class="fas fa-star"></i>
                                              <i class="fas fa-star"></i>
                                              <i class="fas fa-star"></i>
                                              <i class="fas fa-star"></i> 2 days ago
                                            </div>
                                        
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="card-text-1 p-2 review border-bottom">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                                        totam rem aperiam, eaque ipsa quae ab illo inventore
                                        veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit 
                                        aut fugit, sed quia consequuntur magni dolores eos qui ratione 
                                        voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem 
                                        ipsum quia dolor sit amet, consectetur, adipisci velit, sed .
                                        </p>
                                    </div>  
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                <img src="/courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                                <div class="card-body">
                                    <h5 class="card-title text-left">James Parker</h5>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i> 2 days ago
                                        </div>
                                    
                                    </div>
                                </div>
                            
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="card-text-1 p-2 review border-bottom">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                                    totam rem aperiam, eaque ipsa quae ab illo inventore
                                    veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                    Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit 
                                    aut fugit, sed quia consequuntur magni dolores eos qui ratione 
                                    voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem 
                                    ipsum quia dolor sit amet, consectetur, adipisci velit, sed .
                                    </p>
                                </div>  
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                            <img src="/courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                            <div class="card-body">
                                <h5 class="card-title text-left">James Parker</h5>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i>
                                      <i class="fas fa-star"></i> 2 days ago
                                    </div>
                                
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="card-text-1 p-2 review border-bottom">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                                totam rem aperiam, eaque ipsa quae ab illo inventore
                                veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit 
                                aut fugit, sed quia consequuntur magni dolores eos qui ratione 
                                voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem 
                                ipsum quia dolor sit amet, consectetur, adipisci velit, sed .
                                </p>
                            </div>  
                        </div>
                </div>

                 
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                        <img src="/courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                        <div class="card-body">
                            <h5 class="card-title text-left">James Parker</h5>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i> 2 days ago
                                </div>
                            
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="card-text-1 p-2 review border-bottom">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                            totam rem aperiam, eaque ipsa quae ab illo inventore
                            veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit 
                            aut fugit, sed quia consequuntur magni dolores eos qui ratione 
                            voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem 
                            ipsum quia dolor sit amet, consectetur, adipisci velit, sed .
                            </p>
                        </div>  
                    </div>
            </div>

             
            <div class="row">
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12 d-flex justify-content-center">
                                <img src="/courselist/avatar.png" class="img-fluid rounded-circle mt-3" alt="..." style="width:54px; height:54px;">
                                <div class="card-body">
                                    <h5 class="card-title text-left">James Parker</h5>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i>
                                          <i class="fas fa-star"></i> 2 days ago
                                        </div>
                                    
                                    </div>
                                </div>
                            
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="card-text-1 p-2 review border-bottom">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
                                    totam rem aperiam, eaque ipsa quae ab illo inventore
                                    veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                    Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit 
                                    aut fugit, sed quia consequuntur magni dolores eos qui ratione 
                                    voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem 
                                    ipsum quia dolor sit amet, consectetur, adipisci velit, sed .
                                    </p>
                                </div>  
                            </div>
                    </div>
             
                    </div>
                </div> 
            </div>
        </div>
    </section>

<script>
    document.getElementById('enrollButton').addEventListener('click', (e) => {
    e.preventDefault();
    
    
    let path ="{{ route('student.course.enroll') }}";
    fetch(path, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": document.querySelector('input[name=_token]')
            },
            
        }).then((response) => response.json()).then((data) => {
           console.log(data);
           if (data.status =='success'){
            let courseId = document.getElementById('course_id').value;
            window.location.href ="/register-course?id="+courseId;
            
           }else{
               let loginModal = new bootstrap.Modal(
               document.getElementById("loginModal"),{
               });
       
               loginModal.show();
           }
        });
});
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
</script>
<script type="text/javascript" src="{{ asset('/assets/app.js') }}"></script>
@endsection('content')