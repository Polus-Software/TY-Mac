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


//for signup form
// document.querySelector('#signupForm').addEventListener('submit', (e) => {
//     e.preventDefault();
//         if(firstname.value === '') {
//             showError(firstname,'First name is required');
//         } else {
//           removeError(firstname)
//         }
//         if(lastname.value === '') {
//             showError(lastname,'Last name is required');
//         } else {
//           removeError(lastname)
//         }
//         if(email.value === '') {
//             showError(email,'Email is required');
//         }else if(!isValidEmail(email.value)){
//             showError(email,'Email is not valid');
//         } else {
//           removeError(email)
//         }
//         if(password.value === '') {
//             showError(password,'Password is required');
//         } else {
//           removeError(password)
//         }
//         if(passwordconfirm.value === ''){
//             showError(passwordconfirm,'Confirm password is required');
//         } else {
//           removeError(passwordconfirm)
//         }
//         if (password.value != passwordconfirm.value) {
//             showError(password,'The two passwords do not match');
//         } else if (password.value == passwordconfirm.value && password.value != '') {
//           removeError(password)
//         }
// });

//   const form = document.getElementById('signupForm');
//   const firstname = document.getElementById('firstName');
//   const lastname = document.getElementById('lastName');
//   const email = document.getElementById('inputEmail');
//   const password = document.getElementById('inputPassword');
//   const passwordconfirm = document.getElementById('password_confirmation');
  

//   function showError(input,message){
//     input.style.borderColor = 'red';
//     const formControl=input.parentElement;
//     const small=formControl.querySelector('small');
//     small.innerText=message;
//     small.style.visibility = 'visible';
// }

// function removeError(input){
//   input.style.borderColor = '#ced4da';
//   const formControl=input.parentElement;
//   const small=formControl.querySelector('small');
//   small.style.visibility = 'hidden';
// }

// // function showSuccess(input){
// //     const formControl=input.parentElement;
// //     formControl.className='form-control success';
    
// // }


// function isValidEmail(email)
// {
//     const re= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return re.test(String(email).toLowerCase());
// }



//for login form
// document.querySelector('#loginForm').addEventListener('submit', (e) => {debugger
//   e.preventDefault();
     
//       if(email.value === '') {
//           showError(email,'Email is required');
//           //alert('email is required');
//       }else if(!isValidEmail(email.value)){
//           showError(email,'Email is not valid');
//       } else {
//         removeError(email)
//       }
//       if(password.value === '') {
//           showError(password,'Password is required');
//       } else {
//         removeError(password)
//       }
// });

// const loginform = document.getElementById('loginForm');
// const loginemail = document.getElementById('inputEmail');
// const loginpassword = document.getElementById('inputPassword');
   

// function showError(input,message){
//   input.style.borderColor = 'red';
//   const formControl=input.parentElement;
//   const small=formControl.querySelector('small');
//   small.innerText=message;
//   small.style.visibility = 'visible';
// }

// function removeError(input){
// input.style.borderColor = '#ced4da';
// const formControl=input.parentElement;
// const small=formControl.querySelector('small');
// small.style.visibility = 'hidden';
// }






