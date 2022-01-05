function viewPassword()
{
  var passwordInput = document.getElementById('inputPassword');
  var passStatus = document.getElementById('togglePassword');
 
  if (passwordInput.type == 'password'){
    passwordInput.type='text';
    passStatus.className='fas fa-eye';
    
  }
  else{
    passwordInput.type='password';
    passStatus.className='fas fa-eye-slash';
  }
}

function showPassword()
{
  var passwordInput = document.getElementById('password_confirmation');
  var passStatus = document.getElementById('confirm_togglePassword');
 
  if (passwordInput.type == 'password'){
    passwordInput.type='text';
    passStatus.className='fas fa-eye';
    
  }
  else{
    passwordInput.type='password';
    passStatus.className='fas fa-eye-slash';
  }

}


document.getElementById('search-btn').addEventListener('click', function(e) {
  e.preventDefault();
  let searchTerm = document.getElementById('search-box').value;
  let path = "/course-search?search=" + searchTerm;
  window.location = '/course-search?search=' + searchTerm;
});



