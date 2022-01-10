function viewPassword()
{
  var passwordInput = document.getElementById('inputPassword');
  var password = document.getElementById('password');
  var passStatus = document.getElementById('togglePassword');
  var passwordStatus = document.getElementById('togglePass');
 
  if (passwordInput.type == 'password' || password.type == 'password'){
    passwordInput.type='text';
    password.type = 'text';
    passStatus.className='fas fa-eye';
    passwordStatus.className='fas fa-eye';
    
  }
  else{
    passwordInput.type='password';
    password.type = 'password';
    passStatus.className='fas fa-eye-slash';
    passwordStatus.className='fas fa-eye-slash';
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





