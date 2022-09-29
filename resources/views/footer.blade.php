<!--contact modal-->
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
<!--contact modal ends-->
<footer class="footer">
<div class="container">
  <div class="row text-white justify-content-center mt-3 pb-3"> 
    <div class="col-12 col-sm-3 col-lg-3">
      <h5 class="text-uppercase mb-4">Quick links</h5>
      <ul class="campany-list p-0">
        <li><a href="/aboutus">About Us</a></li>
        <li><a type="button" data-bs-toggle="modal" data-bs-target="#contactModal">Apply to be an instructor</a></li>
        <li><a href="/privacy">Privacy policy</a></li>
        <li><a href="/terms">Terms & conditions</a></li>
      </ul>
    </div>
    <div class="col-12 col-sm-4 col-lg-3">
      <h5 class="text-uppercase mb-4">Connect with us</h5>
      <div class="col-12 footer-sm">
        <a href="https://www.facebook.com/ThinkLitInc" target="_blank"><i class="fab fa-facebook m-0"></i></a>
        <a href="https://twitter.com/thinklit" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://www.linkedin.com/company/thinklit" target="_blank"><i class="fab fa-linkedin"></i></a> 
      </div>
    </div>
      <div class="col-12 col-sm-5 col-lg-6 align-items-end d-flex justify-content-end">
        <span>
        <div class="footer-bottom__copyright align-items-center d-flex justify-content-center">
          <a class="navbar-brand mr-0" href="/"><img src="/storage/logo/ty_mac__vector__white.svg" class="mb-2 ty-footer-logo"></img></a>
          <span class="ty-divider"></span>
          <span> &COPY;
            @php echo date('Y'); @endphp
            <a href="#">ThinkLit</a>, Inc.</span>
          </div>
        </span>
      </div>
      </div>
    </div>
  </footer>
<!-- signup modal -->
@include('modal')
<!-- signup modal ends -->
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