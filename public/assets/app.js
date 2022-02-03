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

function displayPassword(){
  var newPassword = document.getElementById("newPassword");
  var newPassStatus = document.getElementById('newPasswordStatus');

  if (newPassword.type == 'password'){
      newPassword.type = 'text';
      newPassStatus.className = 'fas fa-eye';
}else{
   newPassword.type = 'password';
    newPassStatus.className = 'fas fa-eye-slash';
}
}

/*const textarea = document.querySelector('textarea.autosize');
textarea.addEventListener('input', (e) => {alert(5);
  e.target.style.height = 'auto';
  e.target.style.height = e.target.scrollHeight + 'px';
});*/
/* added by jibi starts for auto resize the textarea and back when closes */
var textarea = document.getElementsByClassName("autosize");
var textarea_auto_height = function(e) {
  e.target.style.height = 'auto';
  e.target.style.height = e.target.scrollHeight + 'px';
}
for (var i=0; i < textarea.length; i++) {
  textarea[i].addEventListener('input', textarea_auto_height, false);
};
var close_button = document.getElementsByClassName("think-modal-close-btn");
var textarea_auto_height_to_normal = function(e) {
  e.currentTarget.parentElement.parentElement.querySelector('.autosize').style.height = 'auto';
  //e.target.style.height = 'auto';
}
for (var j=0; j < close_button.length; j++) {
  close_button[i].addEventListener('click', textarea_auto_height_to_normal, false);
};
/* added by jibi ends */