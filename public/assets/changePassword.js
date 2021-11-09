//side nav links
var nav = document.getElementById("navmenu");
var navlink = document.getElementsByClassName("nav-link");


for (var j = 0; j < navlink.length; j++) {
  navlink[j].addEventListener("click", function() {
  
  var current = document.getElementsByClassName("active")[0];
  const previousIcon = current.getElementsByTagName('i')[0];

  previousIcon.className = previousIcon.className.replace("active", "");
  current.className = current.className.replace(" active", "");
  this.classList.add("active");
  
  const icon = this.getElementsByTagName('i')[0];

  icon.classList.add("active");

  });
}

//eye icon
function viewCurrentPass()
{
  var currentPassword = document.getElementById('currentPassword');

  var passStatus = document.getElementById('togglePassword');
 
  if (currentPassword.type == 'password'){
    currentPassword.type='text';
    passStatus.className='fas fa-eye';
    
  }
  else{
    currentPassword.type='password';
    passStatus.className='fas fa-eye-slash';
  }
}


function viewNewPass()
{
    var newPassword = document.getElementById('newPassword');
    var passStatus = document.getElementById('toggleNewPassword');

    if (newPassword.type == 'password'){
        newPassword.type='text';
        passStatus.className='fas fa-eye';
        
      }
      else{
        newPassword.type='password';
        passStatus.className='fas fa-eye-slash';
      } 
}


function viewConfirmpass(){
    var confirmPassword = document.getElementById('confirmPassword');
    var passStatus = document.getElementById('confirmTogglePassword');

    if (confirmPassword .type == 'password'){
        confirmPassword .type='text';
        passStatus.className='fas fa-eye';
        
      }
      else{
        confirmPassword .type='password';
        passStatus.className='fas fa-eye-slash';
      } 

}

//validation
document.querySelector('#changePasswordForm').addEventListener('submit', (e) => {
  
  
    if(currentPass.value === '') {
        e.preventDefault();
        showError(currentPass,' Current Password is required');
    } else {
      removeError(currentPass)
    }
    if(newPass.value === '') {
        e.preventDefault();
        showError(newPass,' New Password is required');
    } else {
      removeError(newPass)
    }
    if(confirmPass.value === ''){
        e.preventDefault();
        showError(confirmPass,'Confirm password is required');
    } else {
      removeError(confirmPass)
    }
    if(currentPass.value === newPass.value){
        e.preventDefault();
        showError(newPass,'  Current password and New Password cannot be same');
    }else {
        removeError(currentPass)
      }
    if (newPass.value != confirmPass.value) {
        e.preventDefault();
        showError(confirmPass,'The two passwords do not match');
    } else if (newPass.value == confirmPass.value && newPass.value != '') {
      removeError(password)
    }
    



    });
  
    const changePass = document.getElementById('changePasswordForm');
    const currentPass = document.getElementById('currentPassword');
    const newPass = document.getElementById('newPassword');
    const confirmPass = document.getElementById('confirmPassword');
  
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
  
  
  





