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

