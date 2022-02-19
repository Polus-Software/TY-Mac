<!-- signup modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0">
        <div class="modal-header border-0 flex-column justify-content-start align-items-start mb-2">
          <h5 class="modal-title custom-form-header" id="signupModalLabel">Create an account</h5>
          <button type="button" class="btn-close think-modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
            <form id="signupForm" class="form" method="POST" action="{{ route('user.create') }}">
              @csrf
              <input type="hidden" name="_method" value="POST">
              <div class="form-group mx-0">
              <label for="firstName" class="firstname-label">First Name</label>
                <input type="text" name="firstname" class="form-control" id="firstName" placeholder="Eg: Denis" value="{{old('firstname')}}">
                <small>Error message</small>
                @if ($errors->has('firstname'))
                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
              <label for="lastName" class="lastname-label">Last Name</label>
                <input type="text" name="lastname" class="form-control" id="lastName" placeholder="Eg: Cheryshev" value="{{old('lastname')}}">
                <small>Error message</small>
                @if ($errors->has('lastname'))
                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
              <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Eg: xyz@domainname.com" value="{{old('email')}}">
                <small>Error message</small>
                @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
              <label for="inputPassword" class="password-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <span><i class="fas fa-eye-slash" id="togglePass" onClick="viewPassword()"></i></span>
                <small>Error message</small>
                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
                <label for="confirmPassword" class="password-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Retype password">
                <span><i class="fas fa-eye-slash" id="confirm_togglePassword" onClick="showPassword()"></i></span>
                <small>Error message</small>

                @if ($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
              <label class="form-check-label checkbox-text fw-normal" id="chechbox-text">
                  <input class="form-check-input" name="privacy_policy" type="checkbox" id="checkbox"> 
                  By creating an account, you agree to the
                  <a href="#">Terms of Service</a> and Privacy Policy <br>
                  <small>Error message</small>
                </label>
                 
                @if ($errors->has('privacy_policy'))
                <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
                <button type="submit" class="btn think-btn-secondary w-100 loginBtn">Create</button>
              </div>
              <div class="form-group mx-0 text-center bottom-text">
              <p>
              <span>Already have an account?</span>
              <span class="login"><a href="" id="login_link">&nbsp;Login</a></span>
              </p>                
              </div>
              <input type="hidden" name="redirect_page" id="redirect_page" class="redirect_page" value="">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- signup modal ends -->
  <!-- login modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content border-0">
        <div class="modal-header border-0 flex-column justify-content-start align-items-start mb-2">
          <h5 class="modal-title custom-form-header" id="loginModalLabel">Log in to account</h5>
          <button type="button" class="btn-close think-modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
          <form id="loginForm" class="form" method="POST" action="{{route('user.login')}}">
              @csrf
              <div class="form-group mx-0">
                <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Eg: xyz@domainname.com" value="{{old('email')}}">
                <small>Error message</small>
                @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
              <label for="inputPassword" class="password-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" value="{{old('password')}}">
                <span><i class="fas fa-eye-slash" id="togglePassword" onClick="viewPassword()"></i></span>
                <small>Error message</small>
                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
              <label class="form-check-label rememberme"><input class="form-check-input" name="remember_me" type="checkbox" id="remember_me"> &nbsp;Remember me</label>
              </div>
              <div class="form-group mx-0">
              <span class="forgotpwd"><a href="{{ route('forget.password.get')}}"> Forgot password? </a></span>
              </div>
              <div class="form-group mx-0 d-grid">
              <button type="submit" class="btn loginBtn think-btn-secondary">Login</button>
              <span class="login-error-message mt-2 text-center text-danger"></span>
              </div>
              <div class="form-group mx-0">
              <span>
                  <p>Don't have an account?
                </span>
                <span class="login"><a href="" id="signup_link">&nbsp;Sign up</a></p></span>
              </div>
              <input type="hidden" name="redirect_page" id="redirect_page" class="redirect_page" value="">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- login modal ends -->
<!-- contact modal -->
@if(Request::is('/'))
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
<div class="modal-dialog think-modal-max-w-600">
      <div class="modal-content border-0">
        <div class="modal-header border-0 flex-column justify-content-start align-items-start mb-2">
          <h5 class="modal-title custom-form-header" id="contactModalLabel">Contact us</h5>
          <button type="button" class="btn-close think-modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
          <form id="contactForm" class="form" method="POST" action="{{route('user.contact')}}">
              @csrf
              <div class="form-group mx-0">
              <label for="name" class="name-label">Name</label>
                <input type="text" name="name" class="form-control" id="contactName" placeholder="Eg: Andrew Bernard">
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
              <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="contactEmail" placeholder="Eg: xyz@domainname.com">
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
              <label for="phone" class="phone-label">Phone</label>
                <input type="tel" name="phone" class="form-control" id="contactPhone" placeholder="Eg: +1 202-555-0257">
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
              <label for="message" class="message-label">Message</label>
                <textarea name="message" class="form-control autosize" id="contactMessage" placeholder="Type your message here"></textarea>
                <small>Error message</small>
              </div>
              <div class="form-group mx-0 d-grid">
              <button type="submit" class="btn think-btn-secondary sendContactInfo">Submit</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif 
  <!-- contact modal ends -->
<!-- question modal -->
@if(Request::is('enrolled-course/*'))
<div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-container mx-auto p-3 rounded">
      <div class="modal-content border-0">
        <div class="modal-header border-0">
          <h5 class="modal-title mx-sm-5 mx-0 custom-form-header" id="questionModalLabel">Ask a question</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
            <form id="questionForm" class="form" method="POST" action="{{route('user.contact')}}">
              @csrf
              <div class="form-group mx-sm-5 mx-0">
                <label for="studentQuestion" class="question-label">Question</label>
                <textarea name="message" class="form-control mt-2 autosize" id="studentQuestion" placeholder="Type your question here" required></textarea>
                <small id="question_error" style="color:red;"></small>
              </div>
              <div class="d-grid form-group  mx-sm-5 mx-0 mt-2">
                <button type="button" class="btn think-btn-secondary" id="submitStudentQuestion">Submit</button>
              </div>

            </form>
          </div>
        </div>
        <div class="modal-footer border-0"></div>
      </div>
    </div>
  </div>
  @endif
  <!-- question modal ends -->
  <!-- review modal -->
  @if(Request::is('enrolled-course/*'))
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
<div class="modal-dialog think-modal-max-w-600">
      <div class="modal-content border-0">
        <div class="modal-header border-0 flex-column justify-content-start align-items-center mb-2">
          <h5 class="modal-title custom-form-header" id="contactModalLabel">Add review</h5>
          <button type="button" class="btn-close think-modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>       
            <div class="think-text-secondary-color">We'd appreciate your feedback!</div>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
                <!--<div class="form-group mx-0 text-center">
                <i class="far fa-thumbs-up fa-3x think-review"></i>
              </div>-->
              <div class="form-group mx-0">
              <div class="rating text-center mb-3">
                    <label for="star1" class="fas fa-star rating-star" star-rating="1"></label>
                    <label for="star2" class="fas fa-star rating-star" star-rating="2"></label>
                    <label for="star3" class="fas fa-star rating-star" star-rating="3"></label>
                    <label for="star4" class="fas fa-star rating-star" star-rating="4"></label>
                    <label for="star5" class="fas fa-star rating-star" star-rating="5"></label>
                </div>
              </div>
              <div class="form-group mx-0">
                <textarea class="form-control autosize" id="comment" placeholder="Add your review..." rows="4" maxlength="60"></textarea>
              </div>
              <div class="form-group mx-0">
              @csrf
                <button type="button" id="reviewSubmitBtn" class="btn think-btn-secondary sendContactInfo w-100">Submit</button>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endif
<!-- review modal ends -->
<!-- Have a question modal -->
@if(Request::is('show-course/*'))
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog think-modal-max-w-600">
      <div class="modal-content border-0">
        <div class="modal-header border-0 flex-column justify-content-start align-items-start mb-2">
          <h5 class="modal-title custom-form-header" id="contactModalLabel">Have a question?</h5>
          <button type="button" class="btn-close think-modal-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>       
            <div class="think-text-secondary-color">If do you have queries to ask us? Then ask here!</div>
        </div>
        <div class="modal-body">
          <div class="container-overlay">
            <form id="contactFormCourse" class="form" method="POST" action="{{route('question')}}">
              @csrf
              <input type="hidden" name="course_id" class="course_id" id="course_id">
              <div class="form-group mx-0">
                <label for="name" class="name-label">Name</label>
                <input type="text" name="name" class="form-control" id="contactNameCourse" placeholder="Eg: Andrew Bernard">
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
                <label for="email" class="email-label">Email</label>
                <input type="email" name="email" class="form-control" id="contactEmailCourse" placeholder="Eg: xyz@domainname.com">
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
                <label for="phone" class="phone-label">Phone</label>
                <input type="tel" name="phone" class="form-control" id="contactPhoneCourse" placeholder="Eg: +1 202-555-0257">
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
                <label for="message" class="message-label">Message</label>
                <textarea type="tel" name="message" class="form-control autosize" id="contactMessageCourse" placeholder="Type your message here"></textarea>
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
                <button type="submit" class="btn think-btn-secondary sendContactInfo w-100">Submit</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  <!-- Have a question modal ends -->
  @push('child-scripts')
<script>
document.querySelector('#signupForm').addEventListener('submit', (e) => {
      if (firstname.value === '') {
        e.preventDefault();
        showError(firstname, 'First name is required');
      } else {
        removeError(firstname)
      }
      if (lastname.value === '') {
        e.preventDefault();
        showError(lastname, 'Last name is required');
      } else {
        removeError(lastname)
      }
      if (email.value === '') {
        e.preventDefault();
        showError(email, 'Email is required');
      } else if (!isValidEmail(email.value)) {
        e.preventDefault();
        showError(email, 'Email is not valid');
      } else {
        removeError(email)
      }
      if (password.value === '') {
        e.preventDefault();
        showError(password, 'Password is required');
      } else {
        removeError(password)
      }
      if (passwordconfirm.value === '') {
        e.preventDefault();
        showError(passwordconfirm, 'Confirm password is required');
      } else {
        removeError(passwordconfirm)
      }

      if (password.value != passwordconfirm.value) {
        e.preventDefault();
        showError(password, 'The two passwords do not match');
      } else if (password.value == passwordconfirm.value && password.value != '') {
        removeError(password)
      }
      if (checkbox.checked != true) {
        e.preventDefault();
        showError(checkbox, 'Accept Terms and conditions');
      } else {
        removeError(checkbox)
      }
      if(password.value.length < 5) { 
        e.preventDefault();
        showError(password, 'Minimum 5 characters required');
      }
      if(password.value.length > 12) { 
        e.preventDefault();
        showError(password, 'Maximum 12 characters allowed');
      }
      if(!password.value.match(/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!-_:$#%]).*$/)) {
        e.preventDefault();
        showError(password, 'The password should contain atleast one special character, number and alphabets.');
      }
    });
    const form = document.getElementById('signupForm');
    const firstname = document.getElementById('firstName');
    const lastname = document.getElementById('lastName');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordconfirm = document.getElementById('password_confirmation');
    const checkbox = document.getElementById('checkbox');
   
  
    function showError(input, message) {
      input.style.borderColor = 'red';
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.innerText = message;
      small.style.visibility = 'visible';
    }
  

    function removeError(input) {
      input.style.borderColor = '#ced4da';
      const formControl = input.parentElement;
      const small = formControl.querySelector('small');
      small.style.visibility = 'hidden';
    }

    function isValidEmail(email) {
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }

    const loginform = document.getElementById('loginForm');
    const loginemail = document.getElementById('inputEmail');
    const loginpassword = document.getElementById('inputPassword');
    document.querySelector('#loginForm').addEventListener('submit', (e) => {//debugger
      e.preventDefault();
      const email = loginemail.value.trim();
      const password = loginpassword.value.trim();
      let loginrememberme = 0;
      if(document.getElementById('remember_me').checked){
        loginrememberme = 1;
      }
      let validLogin = true;
      let redirect_to = '';
      if (email === '') {
        e.preventDefault();
        showError(loginemail, 'Email is required');
        validLogin = false;
      } else {
        removeError(loginemail)
      }
      if (password === '') {
        e.preventDefault();
        showError(loginpassword, 'Password is required');
        validLogin = false;
      } else {
        removeError(loginpassword)
      }
      if(!validLogin) return;
      redirect_to = document.getElementById('redirect_page').value;
      submitLogin(email, password,redirect_to,loginrememberme);
    });

    const submitLogin = (email, password,redirect,rememberme) => {
      const errorEl = document.querySelector('.login-error-message');
      let path = `{{route('user.login')}}?email=${email}&password=${password}&redirect=${redirect}&remember_me=${rememberme}`;
      fetch(path, {
          method: 'POST',
          headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              "X-CSRF-Token": document.querySelector('input[name=_token]').value
          },
          body: JSON.stringify({})
      }).then((response) => response.json()).then((data) => {//debugger
        console.log(data);
        if(data.status ==='success') {
          location.replace(data.url);
        } else {
          errorEl.textContent = data.message;
          return;
        }
      });
    }

const myModalEl = document.getElementById('loginModal')
myModalEl.addEventListener('show.bs.modal', function (event) {
  document.querySelector('.login-error-message').textContent = '';
})

    document.getElementById('signup_link').addEventListener('click', function(e) {
      e.preventDefault();
      closeModal('loginModal');
      document.getElementById('signup_navlink').click();
    });

    document.getElementById('login_link').addEventListener('click', function(e) {
      e.preventDefault();
      closeModal('signupModal');
      document.getElementById('login_navlink').click();
    });

    function closeModal(modalId) {
    const truck_modal = document.querySelector('#' + modalId);
    const modal = bootstrap.Modal.getInstance(truck_modal);
    console.log(modal);
    modal.hide();
  }
  </script>
  @if(Request::is('/'))
  <script>
  const contactName = document.getElementById('contactName');
  const contactEmail = document.getElementById('contactEmail');
  const contactPhone = document.getElementById('contactPhone');
  const contactMessage = document.getElementById('contactMessage');
  
    document.querySelector('#contactForm').addEventListener('submit', (e) => {
      if (contactName.value === '') {
        e.preventDefault();
        showError(contactName, 'Name is required');
      } else {
        removeError(contactName)
      }
      if (contactEmail.value === '') {
        e.preventDefault();
        showError(contactEmail, 'Email is required');
      } else {
        removeError(contactEmail)
      }
      if (contactPhone.value === '') {
        e.preventDefault();
        showError(contactPhone, 'Phone number is required');
      } else {
        removeError(contactPhone)
      }
      if (contactMessage.value === '') {
        e.preventDefault();
        showError(contactMessage, 'Message is required');
      } else {
        removeError(contactMessage)
      }
    });
</script>
@elseif(Request::is('show-course/*'))
<script>
    const contactNameCourse = document.getElementById('contactNameCourse');
    const contactEmailCourse = document.getElementById('contactEmailCourse');
    const contactPhoneCourse = document.getElementById('contactPhoneCourse');
    const contactMessageCourse = document.getElementById('contactMessageCourse');
    document.querySelector('#contactFormCourse').addEventListener('submit', (e) => {
      if (contactNameCourse.value === '') {
        e.preventDefault();
        showError(contactNameCourse, 'Name is required');
      } else {
        removeError(contactNameCourse)
      }
      if (contactEmailCourse.value === '') {
        e.preventDefault();
        showError(contactEmailCourse, 'Email is required');
      } else {
        removeError(contactEmailCourse)
      }
      if (contactPhoneCourse.value === '') {
        e.preventDefault();
        showError(contactPhoneCourse, 'Phone number is required');
      } else {
        removeError(contactPhoneCourse)
      }
      if (contactMessageCourse.value === '') {
        e.preventDefault();
        showError(contactMessageCourse, 'Message is required');
      } else {
        removeError(contactMessageCourse)
      }
    });

    
</script>
@endif

<script>
  var contactModal = document.getElementById('contactModal');
  if(contactModal){
  contactModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget;
    var recipient = button.getAttribute('data-bs-id')
    var modalBodyButton = contactModal.querySelector('.modal-body .course_id');
    modalBodyButton.value = recipient;

  });
  }
</script>
@endpush
  