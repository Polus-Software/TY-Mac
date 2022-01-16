<!-- signup modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog think-modal-max-w-600">
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
              <label class="form-check-label checkbox-text">
                  <input class="form-check-input" name="privacy_policy" type="checkbox"> By creationg an account , you agree to the
                  <a href="#">Terms of Service</a> and Conditions, and Privacy Policy</label>
                @if ($errors->has('privacy_policy'))
                <span class="text-danger">{{ $errors->first('privacy_policy') }}</span>
                @endif
              </div>
              <div class="form-group mx-0">
                <button type="submit" class="btn btn-secondary think-btn-secondary w-100 loginBtn"><span class="button">Create</span></button>
              </div>
              <div class="form-group mx-0 text-center bottom-text">
              <p>
              <span>Already have an account?</span>
              <span class="login"><a href="" id="login_link">&nbsp;Login</a></span>
              </p>                
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- signup modal ends -->
  <!-- login modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog think-modal-max-w-600">
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
              <label class="form-check-label rememberme"><input class="form-check-input" name="remember_me" type="checkbox"> &nbsp;Remember me</label>
              </div>
              <div class="form-group mx-0">
              <span class="forgotpwd"><a href="{{ route('forget.password.get')}}"> Forgot password? </a></span>
              </div>
              <div class="form-group mx-0 d-grid">
              <button type="submit" class="btn btn-secondary loginBtn"><span class="button">Login</span></button>
              </div>
              <div class="form-group mx-0">
              <span>
                  <p>Don't have an account?
                </span>
                <span class="login"><a href="" id="signup_link">&nbsp;Sign up</a></p></span>
              </div>
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
                <textarea name="message" class="form-control" id="contactMessage" placeholder="Type your message here"></textarea>
                <small>Error message</small>
              </div>
              <div class="form-group mx-0 d-grid">
              <button type="submit" class="btn btn-secondary sendContactInfo"><span class="button">Submit</span></button>
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
                <textarea name="message" class="form-control mt-2" id="studentQuestion" placeholder="Type your question here" required></textarea>
                <small id="question_error" style="color:red;"></small>
              </div>
              <div class="d-grid form-group  mx-sm-5 mx-0 mt-2">
                <button type="button" class="btn btn-dark" id="submitStudentQuestion"><span class="button">Submit</span></button>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h3 class="modal-title ms-auto" id="reviewModalLabel">Add review</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="rating text-center mb-3">
                    <label for="star1" class="fas fa-star rating-star" star-rating="1"></label>
                    <label for="star2" class="fas fa-star rating-star" star-rating="2"></label>
                    <label for="star3" class="fas fa-star rating-star" star-rating="3"></label>
                    <label for="star4" class="fas fa-star rating-star" star-rating="4"></label>
                    <label for="star5" class="fas fa-star rating-star" star-rating="5"></label>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-6 comment-area m-auto ">
                    <textarea class="form-control" id="comment" placeholder="Leave your comment..." rows="4" maxlength="60"></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 mb-3">
                @csrf
                <button type="button" id="reviewSubmitBtn" class="col-lg-6 col-md-6 col-sm-6 col-6 btn btn-dark m-auto">Submit</button>
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
                <textarea type="tel" name="message" class="form-control" id="contactMessage" placeholder="Type your message here"></textarea>
                <small>Error message</small>
              </div>
              <div class="form-group mx-0">
                <button type="submit" class="btn btn-secondary think-btn-secondary sendContactInfo w-100"><span class="button">Submit</span></button>
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

    });
    const form = document.getElementById('signupForm');
    const firstname = document.getElementById('firstName');
    const lastname = document.getElementById('lastName');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordconfirm = document.getElementById('password_confirmation');


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
    document.querySelector('#loginForm').addEventListener('submit', (e) => {
      if (loginemail.value === '') {
        e.preventDefault();
        showError(loginemail, 'Email is required');
      } else {
        removeError(loginemail)
      }
      if (loginpassword.value === '') {
        e.preventDefault();
        showError(loginpassword, 'Password is required');
      } else {
        removeError(loginpassword)
      }
    });

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
  
    document.querySelector('#contactForm').addEventListener('submit', (e) => {debugger
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
@endif
@endpush
  